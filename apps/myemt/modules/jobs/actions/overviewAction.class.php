<?php

class overviewAction extends EmtManageJobAction
{
    protected $enforceJob = false;
    
    public function execute($request)
    {
        $this->hrprofile = $this->owner->getHRProfile();
        
        $this->online_pager = $this->owner->getJobPager(1, 5, null, JobPeer::JSTYP_ONLINE);
        $this->offline_pager = $this->owner->getJobPager(1, 5, null, JobPeer::JSTYP_OFFLINE);
        
        $this->used_items = PurchasePeer::getUsedItemsFor($this->owner->getId(), $this->otyp, ServicePeer::STYP_JOB_ANNOUNCEMENT, true);
        $this->purchased_items = PurchasePeer::getPurchasedItemCountFor($this->owner->getId(), $this->otyp, ServicePeer::STYP_JOB_ANNOUNCEMENT, true);
        
    }
    
    public function handleError()
    {
    }
    
}
