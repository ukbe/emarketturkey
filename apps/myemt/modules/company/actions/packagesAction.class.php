<?php

class packagesAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        $serviceid = $this->getRequestParameter('sid');
        
        $this->service = ServicePeer::retrieveByPK($serviceid);
        
        if (!$this->service) $this->redirect('@homepage');

        $this->packages = $this->service->getBasePackage(null, MarketingPackageItemPeer::QUANTITY);
    }
    
    public function handleError()
    {
    }
    
}
