<?php

class Service extends BaseService
{
    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentServiceI18n($culture);
        return $lsi->isNew()?false:true;
    }
    
    public function getBasePackage($quantity = null, $order_by = null)
    {
        $con = Propel::getConnection();
        
        if (isset($order_by) && is_array($order_by)) $order_by = implode(',', $order_by);
        
        $sql = "
            SELECT EMT_MARKETING_PACKAGE.* FROM EMT_MARKETING_PACKAGE
            LEFT JOIN EMT_MARKETING_PACKAGE_ITEM ON EMT_MARKETING_PACKAGE.ID=EMT_MARKETING_PACKAGE_ITEM.PACKAGE_ID
            WHERE EXISTS 
            (
                SELECT 1 FROM EMT_MARKETING_PACKAGE_ITEM
                WHERE PACKAGE_ID=EMT_MARKETING_PACKAGE.ID AND SERVICE_ID=".$this->getId()." 
                ".(is_numeric($quantity) ? "AND QUANTITY=$quantity" : "")."
                GROUP BY EMT_MARKETING_PACKAGE_ITEM.PACKAGE_ID
                HAVING COUNT(*)=1
            )
            ".(isset($order_by) ? "ORDER BY $order_by" : "")."
        ";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        $res = MarketingPackagePeer::populateObjects($stmt);
        return count($res) && Isset($quantity) ? $res[0] : $res;
    }

    public static function getFeaturedPackages($cus_typ_id = null)
    {
        $c = new Criteria();
        $c->addJoin(MarketingPackagePeer::ID, MarketingPackageItemPeer::PACKAGE_ID, Criteria::LEFT_JOIN);
        $c->addJoin(MarketingPackageItemPeer::SERVICE_ID, ServicePeer::ID, Criteria::LEFT_JOIN);
        $c->add(MarketingPackagePeer::IS_FEATURED, 1);
        $c->add(ServicePeer::ID, $this->getId());
        if ($cus_typ_id) $c->add(MarketingPackagePeer::APPLIES_TO_TYPE_ID, $cus_typ_id);
        $c->addAscendingOrderByColumn(MarketingPackagePeer::APPLIES_TO_TYPE_ID);
        return MarketingPackagePeer::doSelect($c);
    }
}
