<?php

class viewAction extends EmtB2bLeadAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect("@camp.lead-detail?guid={$request->getParameter('guid')}", 301);

        $this->getResponse()->setTitle($this->lead . ' | eMarketTurkey');

        $this->photos = $this->lead->getPhotos();
        $this->payment_terms = $this->lead->getPaymentTermList();
        
        RatingPeer::logNewVisit($this->lead->getId(), PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD);
    }
    
    public function handleError()
    {
    }
    
}