<?php

class connectionAction extends EmtAction
{

    public function execute($request)
    {
        $this->user = myTools::unplug($this->getRequestParameter('user'), true);

        if ($this->getRequest()->isXmlHttpRequest()) header('Content-type: text/html');

        if (!$this->user && $this->getRequest()->isXmlHttpRequest()) return $this->renderText($this->getContext()->getI18N()->__('ACTION DISALLOWED'));
        if (!$this->user) $this->redirect('@myemt.homepage');

        if ($this->getRequestParameter('mod') == 'remove' && $this->sesuser->isFriendsWith($this->user->getId()))
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
        elseif (!$this->sesuser->isFriendsWith($this->user))
        {
            if ($this->getRequest()->isXmlHttpRequest())
                return $this->renderPartial('global/ajaxSuccess', array('message' => $this->getContext()->getI18N()->__('ACTION DISALLOWED')));
        }
        
        if ($this->getRequest()->isXmlHttpRequest())
            return $this->renderPartial('connection', array('sesuser' => $this->sesuser, 'user' => $this->user, '_ref' => $this->_ref));
        
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