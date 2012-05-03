<?php

class PremiumAccountPeer extends BasePremiumAccountPeer
{
    CONST PA_TYP_GOLD       = 1;
    CONST PA_TYP_PLATINUM   = 2;

    CONST PA_STAT_PENDING   = 1;
    CONST PA_STAT_ACTIVE    = 2;
    CONST PA_STAT_SUSPENDED = 3;
    CONST PA_STAT_EXPIRED   = 4;
    
    public static $icons    = array(self::PA_TYP_GOLD       => array('small'    => '/images/layout/badges/icon-GoldMember-small.png',
                                                                     'medium'   => '/images/layout/badges/icon-GoldMember-medium.png',
                                                                     'large'   => '/images/layout/badges/icon-GoldMember-large.png',
                                                                ),
                                    self::PA_TYP_PLATINUM   => array('small'    => '/images/layout/badges/icon-PlatinumMember-small.png',
                                                                     'medium'   => '/images/layout/badges/icon-PlatinumMember-medium.png',
                                                                     'large'   => '/images/layout/badges/icon-PlatinumMember-large.png',
                                                                )
                                );

    public static function getAccountFor($owner_id, $owner_type_id, $account_type_id = null)
    {
        $con = Propel::getConnection();

        $sql = "
            SELECT * FROM EMT_PREMIUM_ACCOUNT
            WHERE OWNER_ID=$owner_id AND OWNER_TYPE_ID=$owner_type_id
            ".($account_type_id ? "AND ACCOUNT_TYPE_ID=$account_type_id" : '')."
            AND STATUS=".self::PA_STAT_ACTIVE." AND TRUNC(SYSDATE) >= TRUNC(VALID_FROM) AND TRUNC(SYSDATE) <= TRUNC(VALID_TO)
            ORDER BY CREATED_AT DESC
        ";

        $stmt = $con->prepare($sql);
        $stmt->execute();

        $results = self::populateObjects($stmt);
        return count($results) ? $results[0] : null;
    }

}
