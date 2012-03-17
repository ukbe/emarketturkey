<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class respondAction extends EmtAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $i18n = sfContext::getInstance()->getI18N();
        if ($this->hasRequestParameter('rid') && is_numeric($this->getRequestParameter('rid')))
        {
            if ($this->getRequestParameter('typ') == 'inv')
            {
                $this->invite = GroupMembershipPeer::retrieveByPK($this->getRequestParameter('rid'));
                
                if (!$this->invite || !($this->invite->getObjectId()==$this->sesuser->getId() && $this->invite->getObjectTypeId()==PrivacyNodeTypePeer::PR_NTYP_USER))
                {
                    $this->getUser()->setFlash($i18n->__('Failed to respond to group invitation! Group invitation could not be located.'));
                    $this->redirect($this->_ref ? $this->_ref : $this->refUrl);
                }
                if ($this->getRequestParameter('act')=='21')
                {
                    $this->invite->setStatus(GroupMembershipPeer::STYP_ACTIVE);
                    $this->invite->setRoleId(RolePeer::RL_GP_MEMBER);
                }
                elseif ($this->getRequestParameter('act')=='49')
                {
                    $this->invite->setStatus(GroupMembershipPeer::STYP_REJECTED_BY_USER);
                    $this->invite->setRoleId(RolePeer::RL_ALL);
                }
                else
                {
                    $this->redirect($this->_ref ? $this->_ref : $this->refUrl);
                }
                if ($this->invite->isModified())
                    $this->invite->save();
                
                if ($this->getRequestParameter('act')=='21')
                    $this->getUser()->setMessage($i18n->__('Group Invitation Accepted'), $i18n->__('You accepted group invitation from %1u.', array('%1u' => $this->invite->getInviter())));
                else
                    $this->getUser()->setMessage($i18n->__('Group Invitation Ignored'), $i18n->__('You ignored group invitation from %1u.', array('%1u' => $this->invite->getInviter())));
            }
            elseif ($this->getRequestParameter('typ') == 'grp')
            {
                $this->invite = GroupMembershipPeer::retrieveByPK($this->getRequestParameter('rid'));
                if (!$this->invite || !($this->sesuser->can(ActionPeer::ACT_MANAGE_MEMBERS, $this->invite->getGroup())))
                {
                    $this->getUser()->setFlash($i18n->__('Failed to respond to membership request! Group membership request could not be located.'));
                    $this->redirect($this->_ref ? $this->_ref : $this->refUrl);
                }
                if ($this->getRequestParameter('act')=='21')
                {
                    $this->invite->setStatus(GroupMembershipPeer::STYP_ACTIVE);
                    $this->invite->setRoleId(RolePeer::RL_GP_MEMBER);
                }
                elseif ($this->getRequestParameter('act')=='49')
                {
                    $this->invite->setStatus(GroupMembershipPeer::STYP_REJECTED_BY_MOD);
                    $this->invite->setRoleId(RolePeer::RL_ALL);
                }
                else
                {
                    $this->redirect($this->_ref ? $this->_ref : $this->refUrl);
                }
                if ($this->invite->isModified())
                    $this->invite->save();
                
                if ($this->getRequestParameter('act')=='21')
                    $this->getUser()->setMessage($i18n->__('Group Invitation Accepted'), $i18n->__('You accepted group invitation from %1u.', array('%1u' => $this->invite->getInviter())));
                else
                    $this->getUser()->setMessage($i18n->__('Group Invitation Ignored'), $i18n->__('You ignored group invitation from %1u.', array('%1u' => $this->invite->getInviter())));
            }
            elseif ($this->getRequestParameter('typ') == 'stat')
            {
                $this->rupdate = RelationUpdatePeer::retrieveByPK($this->getRequestParameter('rid'));
                if ($this->rupdate && $this->rupdate->getObjectId()==$this->sesuser->getId() && $this->rupdate->getObjectTypeId()==PrivacyNodeTypePeer::PR_NTYP_USER)
                {
                    $this->user = $this->rupdate->getSubject();
                    $relation = $this->sesuser->getRelationWith($this->user->getId());
                    if (!$this->user || !$relation)
                    {
                        $this->getUser()->setFlash($i18n->__('Failed to respond to status change! Status change owner currently does not exist.'));
                        $this->redirect($this->_ref ? $this->_ref : $this->refUrl);
                    }
                    if ($this->getRequestParameter('act')=='21')
                    {
                        $this->rupdate->setStatus(RelationUpdatePeer::RU_STATUS_CONFIRMED);
                        $this->rupdate->save();
                        $relation->setRoleId($this->rupdate->getRoleId());
                        $relation->save();
                        $this->getUser()->setMessage($i18n->__('Relation Update Accepted'), sfContext::getInstance()->getI18N()->__('You accepted relation status update by %1u.', array('%1u' => $this->user)));
                        ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_ACCEPT_RELATION_STATUS_UPDATE, $this->user, $this->rupdate);
                    }
                    elseif ($this->getRequestParameter('act')=='49')
                    {
                        $this->rupdate->setStatus(RelationUpdatePeer::RU_STATUS_IGNORED);
                        $this->rupdate->save();
                        $this->getUser()->setMessage($i18n->__('Relation Update Ignored'), sfContext::getInstance()->getI18N()->__('You ignored relation update by %1u.', array('%1u' => $this->user)));
                    }
                    else
                    {
                        $this->redirect($this->_ref ? $this->_ref : $this->refUrl);
                    }
                    
                }
            }
            else
            {
                $this->relation = RelationPeer::retrieveByPK($this->getRequestParameter('rid'));
                if ($this->relation)
                {
                    $this->user = $this->relation->getUserRelatedByUserId();
                    if (!$this->user)
                    {
                        $this->getUser()->setFlash($i18n->__('Failed to accept network request! Network request owner currently does not exist.'));
                        $this->redirect($this->_ref ? $this->_ref : $this->refUrl);
                    }
                    if ($this->getRequestParameter('act')=='21')
                    {
                        $this->relation->setStatus(RelationPeer::RL_STAT_ACTIVE);
                        $this->relation->setRoleId(RolePeer::RL_NETWORK_MEMBER);
                    }
                    elseif ($this->getRequestParameter('act')=='49')
                    {
                        $this->relation->setStatus(RelationPeer::RL_STAT_REJECTED);
                        $this->relation->setRoleId(RolePeer::RL_ALL);
                    }
                    else
                    {
                        $this->redirect($this->_ref ? $this->_ref : $this->refUrl);
                    }
                    if ($this->relation->isModified())
                        $this->relation->save();
                    
                    if ($this->getRequestParameter('act')=='21')
                    {
                        $this->getUser()->setMessage($i18n->__('Network Request Accepted'), sfContext::getInstance()->getI18N()->__('You accepted network request from %1u', array('%1u' => $this->relation->getUserRelatedByUserId())));
                        ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_ACCEPT_FRIENDSHIP_REQUEST, $this->relation->getUserRelatedByUserId());
                    }
                    else
                        $this->getUser()->setMessage($i18n->__('Network Request Ignored'), sfContext::getInstance()->getI18N()->__('You ignored network request from %1u', array('%1u' => $this->relation->getUserRelatedByUserId())));
                }
            }
        }
        $this->redirect($this->_ref ? $this->_ref : $this->refUrl);
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