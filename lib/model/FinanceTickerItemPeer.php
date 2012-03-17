<?php

class FinanceTickerItemPeer extends BaseFinanceTickerItemPeer
{
    public static $sourceToField = array('google'   => FinanceTickerItemPeer::SYMBOL_GOOGLE,
                                         'yahoo'    => FinanceTickerItemPeer::SYMBOL_YAHOO
                                        );
    
    public static function getSymbolListFor($source)
    {
        $con = Propel::getConnection();
        $sql = "SELECT ".self::$sourceToField[$source]."
                FROM EMT_FINANCE_TICKER_ITEM
                WHERE ".self::$sourceToField[$source]." IS NOT NULL";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public static function retrieveBySymbol($field, $symbol)
    {
        $c = new Criteria();
        $c->add($field, $symbol);
        return self::doSelectOne($c);
    }
}
