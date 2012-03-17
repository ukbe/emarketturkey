<?php

class add2cartAction extends EmtManageJobAction
{
    protected $enforceJob = false;

    public function execute($request)
    {
        $this->profile = $this->owner->getHRProfile();

        $pack = MarketingPackagePeer::validatePackageFor($this->getRequestParameter('pckid'), $this->otyp);
        
        if ($pack && $this->otyp == $this->getRequestParameter('custyp') && $this->owner->getId() == $this->getRequestParameter('cusid')  
            && SecretHub::validate($this->getRequestParameter('sec'), SecretHub::impl($this->getRequestParameter('custyp'), $this->getRequestParameter('cusid'), $pack->getGuid())))
        {
            $this->sesuser->addToCart($pack->getGuid(), $this->owner->getId(), $this->otyp);
        }
        $this->redirect($this->sesuser->getCartUrl());
        
        
    }
    
    public function handleError()
    {
    }
    
}
