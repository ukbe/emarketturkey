<?php

class companyAction extends EmtAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->company = CompanyPeer::retrieveByPK($this->getRequestParameter('id'));
            if (!$this->company) $this->redirect404();
            
            $this->own_company = $this->user->isOwnerOf($this->company);
            
            $this->profile = $this->company->getCompanyProfile();
            $this->people = $this->company->getPeople();
            
            $cat = $this->company->getProductCategory($this->getRequestParameter('cat'));
            if ($cat)
            {
                $this->products = $this->company->getProductsOfCategory($cat->getId());
            }
            else
            {
                $this->products = $this->company->getProducts();
            }
            
            if ($this->profile) $this->contact = $this->profile->getContact();
            if ($this->contact)
            {
                $this->work_address = $this->contact->getWorkAddress();
                $this->work_phone = $this->contact->getWorkPhone(); 
            }
            
            if (!$this->work_address) $this->work_address = new ContactAddress();
            if (!$this->work_phone) $this->work_phone = new ContactPhone();
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