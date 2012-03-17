<?php

class packagesAction extends EmtAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();

        $serviceid = $this->getRequestParameter('sid');
        
        $this->service = ServicePeer::retrieveByPK($serviceid);
        
        if (!$this->service) $this->redirect('service/select');
        
        $c = new Criteria();
        $c->addJoin(MarketingPackagePeer::ID, MarketingPackageItemPeer::PACKAGE_ID, Criteria::LEFT_JOIN);
        $c->addJoin(MarketingPackageItemPeer::SERVICE_ID, ServicePeer::ID, Criteria::LEFT_JOIN);
        $c->add(ServicePeer::ID, $serviceid);
        $c->addDescendingOrderByColumn(MarketingPackagePeer::APPLIES_TO_TYPE_ID);
        $this->packages = MarketingPackagePeer::doSelect($c);
        
    }
    
    public function handleError()
    {
    }
    
}
