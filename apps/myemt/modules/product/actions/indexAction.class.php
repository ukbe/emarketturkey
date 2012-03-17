<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->product = ProductPeer::retrieveByPK($this->getRequestParameter('id'));
            if (!$this->product) $this->redirect404();
            
            $this->company = $this->product->getCompany();
            if (!$this->company) $this->redirect404();
            
            $this->own_company = $this->user->isOwnerOf($this->company);
            
            $this->profile = $this->company->getCompanyProfile();
            $this->people = $this->company->getPeople();
            $this->products = $this->company->getProducts();
            if ($this->profile) $this->contact = $this->profile->getContact();
            if ($this->contact)
            {
                $this->work_address = $this->contact->getWorkAddress();
                $this->work_phone = $this->contact->getWorkPhone(); 
            }
            
            if (!$this->work_address) $this->work_address = new ContactAddress();
            if (!$this->work_phone) $this->work_phone = new ContactPhone();
            
            /*if (!$this->own_company)*/ RatingPeer::logNewVisit($this->product->getId(), PrivacyNodeTypePeer::PR_NTYP_PRODUCT);
        }
        else
        {
            $this->redirect('@b2b.homepage');
        }
    }
    
    public function handleError()
    {
    }
    
}