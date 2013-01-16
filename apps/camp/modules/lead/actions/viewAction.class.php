<?php

class viewAction extends EmtB2bLeadAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle($this->lead . ' | eMarketTurkey');

        $this->photos = $this->lead->getPhotos();
        $this->payment_terms = $this->lead->getPaymentTermList();

        if ($this->lead->isExpired()) $this->getUser()->setMessage(null, 'This trade lead is expired!');
        RatingPeer::logNewVisit($this->lead->getId(), PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD);
    }
    
    public function handleError()
    {
    }
    
}