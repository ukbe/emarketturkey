<?php

class PurchasePeer extends BasePurchasePeer
{
    public static $serviceMatrix = array(
            ServicePeer::STYP_JOB_ANNOUNCEMENT => 
                            array('JOIN' => 'LEFT JOIN EMT_JOB ON EMT_PURCHASE_ITEM.ID=EMT_JOB.PURCHASE_ITEM_ID',
                                  'WHERE' => ''),
            ServicePeer::STYP_ACCESS_CV_DB => 
                            array('JOIN' => 'LEFT JOIN EMT_DATABASE_CV ON EMT_PURCHASE_ITEM.ID=EMT_DATABASE_CV.PURCHASE_ITEM_ID',
                                  'WHERE' => 'EMT_DATABASE_CV.CHANNEL_TYPE_ID=3'), // 3 -> DatabaseCVPeer::CHANNEL_SERVICE
            ServicePeer::STYP_JOB_PLATINUM_LISTING => 
                            array('JOIN' => '',
                                  'WHERE' => ''),
        );

    public static function getPurchasedItemCountFor($buyer_id, $buyer_type_id, $service_id, $return_total = false)
    {
        $con = Propel::getConnection();
        
        $sql = "
          SELECT SUM(EMT_MARKETING_PACKAGE_ITEM.QUANTITY) QUANTITY, EMT_PURCHASE.ID PURCHASE_UD, EMT_PURCHASE_ITEM.ID PURCHASE_ITEM_ID, EMT_MARKETING_PACKAGE.ID MARKETING_PACKAGE_ID FROM EMT_PURCHASE_ITEM 
          LEFT JOIN EMT_MARKETING_PACKAGE ON EMT_PURCHASE_ITEM.PACKAGE_ID=EMT_MARKETING_PACKAGE.ID
          LEFT JOIN EMT_MARKETING_PACKAGE_ITEM ON EMT_MARKETING_PACKAGE.ID=EMT_MARKETING_PACKAGE_ITEM.PACKAGE_ID
          LEFT JOIN EMT_PURCHASE ON EMT_PURCHASE_ITEM.PURCHASE_ID=EMT_PURCHASE.ID
          LEFT JOIN EMT_PAYMENT ON EMT_PURCHASE.ID=EMT_PAYMENT.PURCHASE_ID
          LEFT JOIN EMT_CREDIT_ACCOUNT ON EMT_PAYMENT.CREDIT_ACCOUNT_ID=EMT_CREDIT_ACCOUNT.ID
          
          WHERE (EMT_PAYMENT.STATUS=".PaymentPeer::PAY_STAT_COMPLETE." OR (EMT_PAYMENT.STATUS=".PaymentPeer::PAY_STAT_PENDING." AND EMT_PAYMENT.CREDIT_PAYMENT=0 AND EMT_CREDIT_ACCOUNT.STATUS=1))
              AND EMT_MARKETING_PACKAGE.VALID_FROM <= SYSDATE AND SYSDATE < EMT_MARKETING_PACKAGE.VALID_TO
              AND (
                    (EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT_TYPE_ID=1 AND TRUNC(SYSDATE) < ADD_MONTHS(TRUNC(EMT_PURCHASE.CREATED_AT), EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT))
                    OR
                    (EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT_TYPE_ID=2 AND TRUNC(SYSDATE) < ADD_MONTHS(TRUNC(EMT_PURCHASE.CREATED_AT), EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT * 12))
                  )
              AND EMT_MARKETING_PACKAGE_ITEM.SERVICE_ID=$service_id
              AND EMT_PURCHASE.BUYER_ID=$buyer_id AND EMT_PURCHASE.BUYER_TYPE_ID=$buyer_type_id

          GROUP BY EMT_PURCHASE.ID, EMT_PURCHASE_ITEM.ID, EMT_MARKETING_PACKAGE.ID
        ";

        if ($return_total) $sql = "SELECT SUM(QUANTITY) FROM ($sql)";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        return $return_total ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function getUsedItemsFor($buyer_id, $buyer_type_id, $service_id, $return_total = false)
    {
        $con = Propel::getConnection();
        
        $sql = "
          SELECT COUNT(EMT_MARKETING_PACKAGE_ITEM.QUANTITY) QUANTITY, EMT_PURCHASE.ID PURCHASE_ID, EMT_PURCHASE_ITEM.ID PURCHASE_ITEM_ID, EMT_MARKETING_PACKAGE.ID MARKETING_PACKAGE_ID FROM EMT_PURCHASE_ITEM 
          LEFT JOIN EMT_MARKETING_PACKAGE ON EMT_PURCHASE_ITEM.PACKAGE_ID=EMT_MARKETING_PACKAGE.ID
          LEFT JOIN EMT_MARKETING_PACKAGE_ITEM ON EMT_MARKETING_PACKAGE.ID=EMT_MARKETING_PACKAGE_ITEM.PACKAGE_ID
          LEFT JOIN EMT_PURCHASE ON EMT_PURCHASE_ITEM.PURCHASE_ID=EMT_PURCHASE.ID
          LEFT JOIN EMT_PAYMENT ON EMT_PURCHASE.ID=EMT_PAYMENT.PURCHASE_ID
          LEFT JOIN EMT_CREDIT_ACCOUNT ON EMT_PAYMENT.CREDIT_ACCOUNT_ID=EMT_CREDIT_ACCOUNT.ID"
          .(isset(self::$serviceMatrix[$service_id]) && self::$serviceMatrix[$service_id]['JOIN']!='' ? ' ' . self::$serviceMatrix[$service_id]['JOIN'] : '')."
          
          WHERE (EMT_PAYMENT.STATUS=".PaymentPeer::PAY_STAT_COMPLETE." OR (EMT_PAYMENT.STATUS=".PaymentPeer::PAY_STAT_PENDING." AND EMT_PAYMENT.CREDIT_PAYMENT=0 AND EMT_CREDIT_ACCOUNT.STATUS=1))
              AND EMT_MARKETING_PACKAGE.VALID_FROM <= SYSDATE AND SYSDATE < EMT_MARKETING_PACKAGE.VALID_TO
              AND (
                    (EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT_TYPE_ID=1 AND TRUNC(SYSDATE) < ADD_MONTHS(TRUNC(EMT_PURCHASE.CREATED_AT), EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT))
                    OR
                    (EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT_TYPE_ID=2 AND TRUNC(SYSDATE) < ADD_MONTHS(TRUNC(EMT_PURCHASE.CREATED_AT), EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT * 12))
                  )
              AND EMT_MARKETING_PACKAGE_ITEM.SERVICE_ID=$service_id
              AND EMT_PURCHASE.BUYER_ID=$buyer_id AND EMT_PURCHASE.BUYER_TYPE_ID=$buyer_type_id"
              .(isset(self::$serviceMatrix[$service_id]) && self::$serviceMatrix[$service_id]['WHERE']!='' ? ' AND ' . self::$serviceMatrix[$service_id]['WHERE'] : '')."

          GROUP BY EMT_PURCHASE.ID, EMT_PURCHASE_ITEM.ID, EMT_MARKETING_PACKAGE.ID
          ORDER BY EMT_PURCHASE.CREATED_AT ASC
        ";

        if ($return_total) $sql = "SELECT SUM(QUANTITY) FROM ($sql)";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        return $return_total ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getProvisionFor($buyer_id, $buyer_type_id, $service_id)
    {
        $con = Propel::getConnection();

        $peer = isset(ServicePeer::$peerNames[$service_id]) && ServicePeer::$peerNames[$service_id]!='' ? ServicePeer::$peerNames[$service_id] : '';

        $sql = "
          SELECT EMT_PURCHASE_ITEM.* FROM EMT_PURCHASE_ITEM 
          LEFT JOIN EMT_MARKETING_PACKAGE ON EMT_PURCHASE_ITEM.PACKAGE_ID=EMT_MARKETING_PACKAGE.ID
          LEFT JOIN EMT_MARKETING_PACKAGE_ITEM ON EMT_MARKETING_PACKAGE.ID=EMT_MARKETING_PACKAGE_ITEM.PACKAGE_ID
          LEFT JOIN EMT_PURCHASE ON EMT_PURCHASE_ITEM.PURCHASE_ID=EMT_PURCHASE.ID
          LEFT JOIN EMT_PAYMENT ON EMT_PURCHASE.ID=EMT_PAYMENT.PURCHASE_ID
          LEFT JOIN EMT_CREDIT_ACCOUNT ON EMT_PAYMENT.CREDIT_ACCOUNT_ID=EMT_CREDIT_ACCOUNT.ID
          
          WHERE (EMT_PAYMENT.STATUS=".PaymentPeer::PAY_STAT_COMPLETE." OR (EMT_PAYMENT.STATUS=".PaymentPeer::PAY_STAT_PENDING." AND EMT_PAYMENT.CREDIT_PAYMENT=0 AND EMT_CREDIT_ACCOUNT.STATUS=1))
              AND EMT_MARKETING_PACKAGE.VALID_FROM <= SYSDATE AND SYSDATE < EMT_MARKETING_PACKAGE.VALID_TO
              AND (
                    (EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT_TYPE_ID=1 AND TRUNC(SYSDATE) < ADD_MONTHS(TRUNC(EMT_PURCHASE.CREATED_AT), EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT))
                    OR
                    (EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT_TYPE_ID=2 AND TRUNC(SYSDATE) < ADD_MONTHS(TRUNC(EMT_PURCHASE.CREATED_AT), EMT_MARKETING_PACKAGE_ITEM.TIME_LIMIT * 12))
                  )
              AND EMT_MARKETING_PACKAGE_ITEM.SERVICE_ID=$service_id
              AND EMT_PURCHASE.BUYER_ID=$buyer_id AND EMT_PURCHASE.BUYER_TYPE_ID=$buyer_type_id
              ".($peer ? "AND EMT_MARKETING_PACKAGE_ITEM.QUANTITY > (SELECT COUNT(*) FROM ".constant($peer.'::TABLE_NAME')." WHERE PURCHASE_ITEM_ID=EMT_PURCHASE_ITEM.ID)"  : '')."
              AND ROWNUM=1

          ORDER BY EMT_PURCHASE.CREATED_AT ASC
        ";

        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        $items = PurchaseItemPeer::populateObjects($stmt);
        
        return count($items) ? $items[0] : null;
    }

    public static function getAvailableItemsFor($buyer_id, $buyer_type_id, $service_id, $return_total = false)
    {
        $purchases = self::getPurchasedItemCountFor($buyer_id, $buyer_type_id, $service_id, $return_total);
        $usages = self::getUsedItemsFor($buyer_id, $buyer_type_id, $service_id, $return_total);
        
        return $return_total ? ($purchases - $usages) : (array_sum($purchases) - array_sum($usages));
    }
    
}
