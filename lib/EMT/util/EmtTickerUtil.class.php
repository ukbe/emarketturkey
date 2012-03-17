<?php
/**
 *
 * @package lib
 * @subpackage util
 */

class EmtTickerUtil
{
    public static function update()
    {
        $feeds = sfConfig::get('app_ticker_feeds');

        foreach ($feeds as $source => $feed)
        {
            $symbols = FinanceTickerItemPeer::getSymbolListFor($source);
            if (count($symbols))
            {
                $url = $feed['url'];
                $sym_seperator = $feed['seperator'];
                $url = str_replace('%symbols%', implode($sym_seperator, $symbols), $url);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                $response = curl_exec($ch);
                curl_close($ch);
                $values = call_user_func($feed['parser'].'::parse', $response);
            }
        }
    }

}

class EmtGoogleFinanceResponseParser
{
    public static function parse($response)
    {
        $response = trim(str_replace(array(' ', '//'), '', $response));
        $response = stripslashes($response);
        $values = json_decode(utf8_encode($response), true);
        if (!is_array($values)) return;

        foreach ($values as $row)
        {
            $item = FinanceTickerItemPeer::retrieveBySymbol(FinanceTickerItemPeer::SYMBOL_GOOGLE, $row['e'].':'.$row['t']);
            $item->addData(array('lastprice' => str_replace(',','',$row['l']),
                                 'change' => $row['c'],
                                 'changepercent' => $row['cp']
                            ));
        }
    }
}

class EmtYahooFinanceResponseParser
{
    public static function parse($response)
    {
        $lines = explode("\n", $response);

        if (!is_array($lines)) return;
        
        foreach ($lines as $row)
        {
            if (trim($row) == '') continue;
            $values = str_getcsv($row, ',', '"', '\\');
            $item = FinanceTickerItemPeer::retrieveBySymbol(FinanceTickerItemPeer::SYMBOL_YAHOO, $values[0]);
            
            $item->addData(array('lastprice' => $values[1],
                                 'change' => null,
                                 'changepercent' => null
                            ));
        }
    }
}
