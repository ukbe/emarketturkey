<?php

class editPendingMemberAction extends EmtGroupAction
{
    protected $actionID = ActionPeer::ACT_MANAGE_MEMBERS;
    
    public function execute($request)
    {
        if (!$this->goodToRun) $this->redirect404();
        
        $item_id = $this->getRequestParameter('obj');
        $item_type_id = $this->getRequestParameter('objtyp');

        if (!is_numeric($item_id) || !is_numeric($item_type_id)
            || !($obj = PrivacyNodeTypePeer::retrieveObject($item_id, $item_type_id)))
        {
            return $this->renderText('ERROR');
        }
        
        if ($membership = $this->group->getMembership($item_id, $item_type_id))
        {
            if ($this->getRequestParameter('mod') == 'confirm')
            {
                $membership->setStatus(GroupMembershipPeer::STYP_ACTIVE);
                $membership->save();
                ActionLogPeer::Log($membership->getMember(), ActionPeer::ACT_JOIN_GROUP, $this->group);
                return $this->renderText('Confirmed');
            }
            elseif ($this->getRequestParameter('mod') == 'reject')
            {
                $membership->setStatus(GroupMembershipPeer::STYP_REJECTED_BY_MOD);
                $membership->save();
                return $this->renderText('Rejected');
            }
        }
        return $this->renderText('ERROR');
    }
    
    public function handleError()
    {
    }
    
}
