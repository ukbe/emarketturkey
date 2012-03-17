<?php

class MarketingPackage extends BaseMarketingPackage
{
    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentMarketingPackageI18n($culture);
        return $lsi->isNew()?false:true;
    }

    public function getItemByServiceId($styp)
    {
        $c = new Criteria();
        $c->add(MarketingPackageItemPeer::SERVICE_ID, $styp);
        $mis = $this->getMarketingPackageItems($c);
        return count($mis)?$mis[0]:null;
    }

    public function getPriceFor($target)
    {
        // this code is temporary, please develop a hierarchical price selection for the target object
        $c = new Criteria();
        $pro = $this->getMarketingPackagePrices($c);
        return count($pro) ? $pro[0] : $pro;
    }
    
}
