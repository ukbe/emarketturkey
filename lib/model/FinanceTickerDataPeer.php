<?php

class FinanceTickerDataPeer extends BaseFinanceTickerDataPeer
{
    CONST FTD_TYPE_INDEX    = 1;
    CONST FTD_TYPE_CURRENCY = 2;
    
    
    public static function getTickerData($type_id = null, $country = null)
    {
        $i = sfConfig::get('app_ticker_updateInterval')*60;

        $c = new Criteria();
        $c->addDescendingOrderByColumn(FinanceTickerDataPeer::CREATED_AT);
        $latest = FinanceTickerDataPeer::doSelectOne($c);
        if (!$latest || ($latest && (time() - $latest->getCreatedAt('U')) > $i ))
        {
            //echo "yes";die;
            EmtTickerUtil::update();
        }

        $con = Propel::getConnection();
        $sql = "SELECT DAT.*
                FROM
                (
                    SELECT EMT_FINANCE_TICKER_DATA.*, RANK() OVER (PARTITION BY ITEM_ID ORDER BY EMT_FINANCE_TICKER_DATA.CREATED_AT DESC) SQNUM
                    FROM EMT_FINANCE_TICKER_DATA
                ) DAT
                LEFT JOIN EMT_FINANCE_TICKER_ITEM ON DAT.ITEM_ID=EMT_FINANCE_TICKER_ITEM.ID
                WHERE SQNUM = 1
                ".($country ? "AND (EMT_FINANCE_TICKER_ITEM.IS_GLOBAL= 1 OR EMT_FINANCE_TICKER_ITEM.COUNTRY_CODE='$country')" : "AND EMT_FINANCE_TICKER_ITEM.IS_GLOBAL=1")."
                ".($type_id ? "AND EMT_FINANCE_TICKER_ITEM.TYPE_ID=$type_id" : "")."
                ORDER BY EMT_FINANCE_TICKER_ITEM.IS_GLOBAL ASC
                ";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return self::populateObjects($stmt);
    }
    
}
