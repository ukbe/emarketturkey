<?php

class Application extends BaseApplication
{
    public function __toString()
    {
        return $this->getName()!=''?$this->getName():$this->getName('en'); 
    }
    
    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentApplicationI18n($culture);
        return $lsi->isNew()?false:true;
    }

    public function getExistingServicesFor($cus_typ_id)
    {
        $c = new Criteria();
        $c->addJoin(ServicePeer::ID, MarketingPackageItemPeer::SERVICE_ID, Criteria::LEFT_JOIN);
        $c->addJoin(MarketingPackageItemPeer::PACKAGE_ID, MarketingPackagePeer::ID, Criteria::LEFT_JOIN);
        $c->add(MarketingPackagePeer::APPLICATION_ID, $this->getId());
        $c->setDistinct();
        return $this->getServices($c);
    }
}
