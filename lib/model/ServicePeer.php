<?php

class ServicePeer extends BaseServicePeer
{
    CONST STYP_JOB_ANNOUNCEMENT     = 3;
    CONST STYP_ACCESS_CV_DB         = 4;
    CONST STYP_JOB_SPOT_LISTING     = 5;
    CONST STYP_JOB_PLATINUM_LISTING = 6;
    
    public static $typeNames     = array(self::STYP_JOB_ANNOUNCEMENT => 'Job Announcement',
                                         self::STYP_ACCESS_CV_DB => 'Access CV Database',
                                         self::STYP_JOB_SPOT_LISTING => 'Spot Listing',
                                         self::STYP_JOB_PLATINUM_LISTING => 'Platinum Listing',
                                         );

    public static $peerNames     = array(self::STYP_JOB_ANNOUNCEMENT => 'JobPeer',
                                         self::STYP_ACCESS_CV_DB => null,
                                         self::STYP_JOB_SPOT_LISTING => null,
                                         self::STYP_JOB_PLATINUM_LISTING => null,
                                         );

    public static function getFeaturedServices($cus_typ_id = null)
    {
        $c = new Criteria();
        $c->addJoin(ServicePeer::ID, MarketingPackageItemPeer::SERVICE_ID, Criteria::LEFT_JOIN);
        $c->addJoin(MarketingPackageItemPeer::PACKAGE_ID, MarketingPackagePeer::ID, Criteria::LEFT_JOIN);
        $c->add(MarketingPackagePeer::IS_FEATURED, 1);
        if ($cus_typ_id) $c->add(MarketingPackagePeer::APPLIES_TO_TYPE_ID, $cus_typ_id);
        $c->addAscendingOrderByColumn(MarketingPackagePeer::APPLIES_TO_TYPE_ID);
        return self::doSelect($c);
    }
}
