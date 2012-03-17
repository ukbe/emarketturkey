<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        if (($this->product = ProductPeer::getProductFromUrl($this->getRequest()->getParameterHolder(), null, true)))
        {
            $this->company = $this->product->getCompany();
            
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("%1 from %2", array('%1' => ($this->product->getDisplayName()?$this->product->getDisplayName():$this->product->getName()), '%2' => $this->company->getName())) . ' | eMarketTurkey');
            
            $this->own_company = $this->sesuser->isOwnerOf($this->company);
            
            $this->profile = $this->company->getCompanyProfile();
            $this->products = $this->company->getProducts();
            if ($this->profile) $this->contact = $this->profile->getContact();
            if ($this->contact)
            {
                $this->work_address = $this->contact->getWorkAddress();
                $this->work_phone = $this->contact->getWorkPhone(); 
            }
            
            if (!$this->work_address) $this->work_address = new ContactAddress();
            if (!$this->work_phone) $this->work_phone = new ContactPhone();
            
            if (!$this->own_company) RatingPeer::logNewVisit($this->product->getId(), PrivacyNodeTypePeer::PR_NTYP_PRODUCT);
        }
        else
        {
            $this->redirect('@homepage');
        }
    }
    
    public function handleError()
    {
    }
    
}