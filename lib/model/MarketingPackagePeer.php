<?php

class MarketingPackagePeer extends BaseMarketingPackagePeer
{
    public static function getPackageFor($service_id, $applies_to_type_id, $quantity = null, $time_limit_type = null, $time_limit = null, $include_inactive = false)
    {
        $c = new Criteria();
        $c->addJoin(MarketingPackagePeer::ID, MarketingPackageItemPeer::PACKAGE_ID, Criteria::LEFT_JOIN);
        $c1 = $c->getNewCriterion(MarketingPackagePeer::APPLIES_TO_TYPE_ID, $applies_to_type_id);
        $c2 = $c->getNewCriterion(MarketingPackagePeer::APPLIES_TO_TYPE_ID, null, Criteria::ISNULL);
        $c1->addOr($c2);
        $c->addAnd($c1);
        $c->add(MarketingPackageItemPeer::SERVICE_ID, $service_id);
        if (isset($quantity)) $c->add(MarketingPackageItemPeer::QUANTITY, $quantity);
        if (isset($time_limit_type)) $c->add(MarketingPackageItemPeer::TIME_LIMIT_TYPE_ID, $time_limit_type);
        if (isset($time_limit)) $c->add(MarketingPackageItemPeer::TIME_LIMIT, $time_limit);
        if (!$include_inactive) $c->add(MarketingPackagePeer::ACTIVE, 1);
        
        $packs = MarketingPackagePeer::doSelect($c);
        return count($packs) == 1 ? $packs[0] : $packs;
    }

    public static function validatePackageFor($guid, $cus_type_id)
    {
        $c = new Criteria();
        $c1 = $c->getNewCriterion(MarketingPackagePeer::APPLIES_TO_TYPE_ID, $cus_type_id);
        $c2 = $c->getNewCriterion(MarketingPackagePeer::APPLIES_TO_TYPE_ID, null, Criteria::ISNULL);
        $c1->addOr($c2);
        $c->addAnd($c1);
        $c->add(MarketingPackagePeer::GUID, $guid);

        return MarketingPackagePeer::doSelectOne($c);
    }
}
