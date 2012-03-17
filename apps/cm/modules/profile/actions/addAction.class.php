<?php

class addAction extends EmtUserAction
{
    
    protected $actionID = ActionPeer::ACT_ADD_TO_NETWORK;
    
    public function execute($request)
    {
        if (!$this->getRequest()->isXmlHttpRequest() && $this->getRequestParameter('mod')!='remove')
        {
            $this->setTemplate('nonAjaxAdd');
        }

        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->getRequestParameter('token') != sha1(base64_encode($this->user.session_id()))) $this->redirect404();
        if ($this->getRequestParameter('mod') == 'commit' && !$this->sesuser->isFriendsWith($this->user->getId()))
        {
            if ($this->sesuser->can(ActionPeer::ACT_ADD_TO_NETWORK, $this->user))
            {
                $this->relation = $this->sesuser->setupRelationWith($this->user->getId());
                
                if ($this->relation)
                {
                    $data = new sfParameterHolder();
                    $data->set('cname', $this->user->getName());
                    $data->set('clname', $this->user->getLastname());
                    $data->set('uname', $this->sesuser->getName());
                    $data->set('ulname', $this->sesuser->getLastname());
                    $data->set('ugender', $this->sesuser->getGender());
                    $data->set('message', $this->getRequestParameter('invite_message'));
                    
                    $vars = array();
                    $vars['email'] = $this->user->getLogin()->getEmail();
                    $vars['user_id'] = $this->user->getId();
                    $vars['data'] = $data;
                    $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_NETWORK_REQUEST;
                    
                    EmailTransactionPeer::CreateTransaction($vars);
                
                    $this->getUser()->setMessage('Friendship Request Sent!', 'A friendship request has been sent to %1', 
                                              null, array('%1' => $this->user));
                    if ($this->getRequest()->isXmlHttpRequest())
                    {
                        return $this->renderText(javascript_tag("window.location = '{$this->getRequestParameter('ref')}';"));
                    }
                    else
                    {
                        $this->redirect($this->getRequestParameter('ref'));
                    }
                }
            }
            return $this->renderText($this->getContext()->getI18N()->__('ACTION DISALLOWED'));
        }
        elseif ($this->getRequestParameter('mod') == 'remove' && $this->sesuser->isFriendsWith($this->user->getId()))
        {
            $relation = $this->sesuser->hasRelation($this->user->getId());
            if (!$relation)
            {
                if ($this->getRequest()->isXmlHttpRequest())
                    return $this->renderText($this->getContext()->getI18N()->__('ACTION DISALLOWED'));
                else
                    $this->redirect($this->getRequestParameter('ref'));
            }
            
            if ($this->getRequestParameter('confirm')=='do')
            {
                $relation->setStatus($relation->getUserId()==$this->sesuser->getId() ? RelationPeer::RL_STAT_ENDED_BY_STARTER_USER : RelationPeer::RL_STAT_ENDED_BY_TARGET_USER);
                $relation->save();

                $this->getUser()->setMessage('Removed from Friends!', '%1 has been removed from your friends.', 
                                          null, array('%1' => $this->user));
                if ($this->getRequest()->isXmlHttpRequest())
                {
                    return $this->renderText(javascript_tag("window.location = '{$this->getRequestParameter('ref')}';"));
                }
                else
                {
                    $this->redirect($this->getRequestParameter('ref'));
                }
            }
            else
            {
                return $this->renderPartial('remove_user', array('sesuser' => $this->sesuser, 'user' => $this->user, 'relation' => $relation));
            }
        }
        elseif ($this->getRequestParameter('mod') == 'chanrel' && $this->sesuser->isFriendsWith($this->user->getId()))
        {
            $relation = $this->sesuser->hasRelation($this->user->getId());
            if (!$relation)
            {
                if ($this->getRequest()->isXmlHttpRequest())
                    return $this->renderText($this->getContext()->getI18N()->__('ACTION DISALLOWED'));
                else
                    $this->redirect($this->getRequestParameter('ref'));
            }
            
            if (is_numeric($this->getRequestParameter('relation')))
            {
                $allowedrelations = RoleMatrixPeer::getRelationsAvailableTo(PrivacyNodeTypePeer::PR_NTYP_USER, PrivacyNodeTypePeer::PR_NTYP_USER);
                if (array_search($this->getRequestParameter('relation'), $allowedrelations)!==null)
                {
                    $rel = new RelationUpdate();
                    $rel->setObjectId($this->user->getId());
                    $rel->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                    $rel->setSubjectId($this->sesuser->getId());
                    $rel->setSubjectTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                    $rel->setRoleId($this->getRequestParameter('relation'));
                    $rel->save();
                    
                    return $this->renderPartial('updated_relation', array('sesuser' => $this->sesuser, 'user' => $this->user, 'relation' => $rel));
                }
            }
            else
            {
                return $this->renderPartial('update_relation', array('sesuser' => $this->sesuser, 'user' => $this->user, 'relation' => $relation));
            }
        }
    }

    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}