<?php

class messagingAction extends EmtManageGroupAction
{
    protected $actionID = ActionPeer::ACT_MANAGE_MEMBERS;
    
    public function execute($request)
    {
        $this->undelivered = $this->group->getAnnouncementsByDelivery(false);
        
    }
    
    public function handleError()
    {
    }
    
}
