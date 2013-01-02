<?php

class viewAction extends EmtProductAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle($this->lead . ' | eMarketTurkey');

        $this->photos = $this->lead->getPhotos();
        $this->payment_terms = $this->lead->getPaymentTermList();
        
        RatingPeer::logNewVisit($this->lead->getId(), PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD);
    }
    
    public function handleError()
    {
    }
    
}