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
        if ($this->hasRequestParameter('rid') && is_numeric($this->getRequestParameter('rid')))
        {
            if ($this->getRequestParameter('typ') == 'grp')
            {
                $this->invite = GroupMembershipPeer::retrieveByPK($this->getRequestParameter('rid'));
                if (!$this->invite)
                {
                    $this->getUser()->setFlash('Failed to accept group invitation! Group invitation cold not be located.');
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
                    $this->getUser()->setMessage('Group Invitation Accepted', 'You accepted group invitation from '.$this->invite->getInviter());
                else
                    $this->getUser()->setMessage('Group Invitation Ignored', 'You ignored group invitation from '.$this->invite->getInviter());
            }
            else
            {
                $this->relation = RelationPeer::retrieveByPK($this->getRequestParameter('rid'));
                if ($this->relation)
                {
                    $this->user = $this->relation->getUserRelatedByUserId();
                    if (!$this->user)
                    {
                        $this->getUser()->setFlash('Failed to accept network request! Network request owner currently does not exist.');
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
                        $this->getUser()->setMessage('Network Request Accepted', 'You accepted network request from '.$this->relation->getUserRelatedByUserId());
                    else
                        $this->getUser()->setMessage('Network Request Ignored', 'You ignored network request from '.$this->relation->getUserRelatedByUserId());
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