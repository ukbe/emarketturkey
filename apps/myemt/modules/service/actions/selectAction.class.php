<?php

class selectAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();

        $this->appid = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('appid')), array_keys(ApplicationPeer::$appNames));
        $this->ctyp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ctyp')), array(PrivacyNodeTypePeer::PR_NTYP_USER, PrivacyNodeTypePeer::PR_NTYP_COMPANY, PrivacyNodeTypePeer::PR_NTYP_GROUP));
        $this->cid = myTools::fixInt($this->getRequestParameter('cid'));
        $this->sid = myTools::fixInt($this->getRequestParameter('sid'));
        
        if ($this->cid && $this->ctyp)
        {
            $this->customer = PrivacyNodeTypePeer::retrieveObject($cid, $ctyp);
        }
        else
        {
            $this->customer = null;
        }
        
        if ($this->appid)
        {
            $this->application = ApplicationPeer::retrieveByPK($this->appid);
        }
        else
        {
            $this->application = null;
        }
        

        $c = new Criteria();
        $c->addJoin(ApplicationPeer::ID, ServicePeer::APPLICATION_ID, Criteria::LEFT_JOIN);
        $c->addJoin(ServicePeer::ID, MarketingPackageItemPeer::SERVICE_ID, Criteria::LEFT_JOIN);
        $c->addJoin(MarketingPackageItemPeer::PACKAGE_ID, MarketingPackagePeer::ID, Criteria::LEFT_JOIN);
        $c->add(MarketingPackagePeer::APPLICATION_ID, MarketingPackagePeer::APPLICATION_ID.'='.ApplicationPeer::ID, Criteria::CUSTOM);
        $c->addAscendingOrderByColumn(ApplicationPeer::ID);
        if ($this->customer) $c->add(MarketingPackagePeer::APPLIES_TO_TYPE_ID, $this->ctyp);
        $c->setDistinct();
        $this->applications = ApplicationPeer::doSelect($c);

        $this->services = $this->application ? $this->application->getExistingServicesFor($this->ctyp) : ServicePeer::getFeaturedServices();
    }
    
    public function handleError()
    {
    }
    
}
