<?php

class cvdbAction extends EmtManageJobAction
{
    protected $enforceJob = false;

    public function execute($request)
    {
        $this->profile = $this->owner->getHRProfile();
        $this->keyword = $this->getRequestParameter('cvdb_keyword', '');
        
        $this->used_items = PurchasePeer::getUsedItemsFor($this->owner->getId(), $this->otyp, ServicePeer::STYP_ACCESS_CV_DB, true);
        $this->purchased_items = PurchasePeer::getPurchasedItemCountFor($this->owner->getId(), $this->otyp, ServicePeer::STYP_ACCESS_CV_DB, true);
        $this->credits = myTools::fixInt($this->purchased_items) - myTools::fixInt($this->used_items);
        
        if ($this->credits <= 0)
        {
            return sfView::ALERT;
        }
        
        if ($this->keyword != '')
        {
            
            $this->ipps = array('extended'  => array(10, 20, 50),
                                'list'      => array(10, 20, 50, 100),
                                'thumbs'    => array(20, 50, 100, 150)
                            );

            $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
            $this->view = myTools::pick_from_list($this->getRequestParameter('view'), array_keys($this->ipps), 'list');
            $this->ipp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ipp')), $this->ipps[$this->view], 20);

            $this->getUser()->setAttribute('keyword', $this->keyword, '/myemt/jobs/cvvault/browse');

            $c = $this->profile->searchCVDB($this->keyword, ResumePeer::SRC_RETURN_CRITERIA);

            $this->pager = $this->profile->getCVPager($this->page, $this->ipp, $c);
        }

        $this->cvcounts = array(
            DatabaseCVPeer::CHANNEL_APPLICATION => $this->profile->searchCVDB(null, array(DatabaseCVPeer::CHANNEL_APPLICATION), ResumePeer::SRC_RETURN_COUNT),
            DatabaseCVPeer::CHANNEL_SERVICE => $this->profile->searchCVDB(null, array(DatabaseCVPeer::CHANNEL_SERVICE), ResumePeer::SRC_RETURN_COUNT),
            DatabaseCVPeer::CHANNEL_REFERRAL => 0, // replace zero with function when service is ready
        );
        
        $this->hrcredits = 0;
    }
    
    public function handleError()
    {
    }
    
}
