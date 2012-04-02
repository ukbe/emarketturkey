<?php

class myTools
{
    public static function stripText($text, $en = false)
    {
        //iconv_set_encoding('input_encoding', 'UTF-8');
        //iconv_set_encoding('output_encoding', 'ISO-8859-1');
    
        //$text = mb_convert_encoding($text,'ISO-8859-1');
        if (!$en) $text = myTools::turkishreplace($text);
        
        $text = strtolower($text);
        
        // strip all non word chars
        $text = preg_replace('/\W/', ' ', $text);
     
        // replace all white space sections with a dash
        $text = preg_replace('/\ +/', '-', $text);
     
        // trim dashes
        $text = preg_replace('/\-$/', '', $text);
        $text = preg_replace('/^\-/', '', $text);
     
        return $text;
    }

    public static function turkishreplace($sData)
    {
        $newphrase=$sData;
        $newphrase = str_replace("Ãœ","U",$newphrase);
        $newphrase = str_replace("Å","S",$newphrase);
        $newphrase = str_replace("Ä","G",$newphrase);
        $newphrase = str_replace("Ã‡","C",$newphrase);
        $newphrase = str_replace("Ä°","I",$newphrase);
        $newphrase = str_replace("Ã–","O",$newphrase);
        $newphrase = str_replace("Ã¼","u",$newphrase);
        $newphrase = str_replace("ÅŸ","s",$newphrase);
        $newphrase = str_replace("Ã§","c",$newphrase);
        $newphrase = str_replace("Ä±","i",$newphrase);
        $newphrase = str_replace("Ã¶","o",$newphrase);
        $newphrase = str_replace("ÄŸ","g",$newphrase);
        $newphrase = str_replace("Ü","U;",$newphrase);
        $newphrase = str_replace("Ş","S",$newphrase);
        $newphrase = str_replace("Ğ","G",$newphrase);
        $newphrase = str_replace("Ç","C",$newphrase);
        $newphrase = str_replace("İ","I",$newphrase);
        $newphrase = str_replace("Ö","O",$newphrase);
        $newphrase = str_replace("ü","u",$newphrase);
        $newphrase = str_replace("ş","s",$newphrase);
        $newphrase = str_replace("ç","c",$newphrase);
        $newphrase = str_replace("ı","i",$newphrase);
        $newphrase = str_replace("ö","o",$newphrase);
        $newphrase = str_replace("ğ","g",$newphrase);
        $newphrase = str_replace("%u015F","s",$newphrase);
        $newphrase = str_replace("%E7","c",$newphrase);
        $newphrase = str_replace("%FC","u",$newphrase);
        $newphrase = str_replace("%u0131","i",$newphrase);
        $newphrase = str_replace("%F6","o",$newphrase);
        $newphrase = str_replace("%u015E","S",$newphrase);
        $newphrase = str_replace("%C7","C",$newphrase);
        $newphrase = str_replace("%DC","U",$newphrase);
        $newphrase = str_replace("%D6","O",$newphrase);
        $newphrase = str_replace("%u0130","I",$newphrase);
        $newphrase = str_replace("%u011F","g",$newphrase);
        $newphrase = str_replace("%u011E","G",$newphrase);
        return $newphrase;
    }

    public static function getMailInfo( $processKey )
    {
        $processMailInfo = array_merge(
        sfConfig::get('app_smtpsettings_default', array()), 
        sfConfig::get('app_smtpsettings_'.$processKey, array()));
        return $processMailInfo;        
    }
    
    public static function sendEmail ($vars =  null)
    {
        //Start Swift
        $smtpInfo = self::getMailInfo($vars['namespace']);
        $body = self::renderPartial($smtpInfo['template'], $vars);
        
        $mcon     = new Swift_Connection_SMTP( $smtpInfo['smtp_host'], $smtpInfo['smtp_port'] );
        if ($smtpInfo['username'])
        {
            $mcon->setUsername( $smtpInfo['username'] );
        }
        if ($smtpInfo['password'])
        {
            $mcon->setPassword( $smtpInfo['password'] );
        }
        
        $mailer  = new Swift( $mcon );
        $message = new Swift_Message();
        $headers = new Swift_Message_Headers();
        $headers->setCharset('utf-8');
        $message->setHeaders($headers);
        $message->setSubject($vars['subject']?$vars['subject']:$smtpInfo['email_subject']);
        $message->setBody($body);
        $message->setContentType($vars['format']);
        
        $mailer->send( $message, new Swift_Address($vars['recipient']), new Swift_Address($smtpInfo['email_sender_address']) );
    }

    public static function renderPartial($templateName, $vars = null)
    {
        sfLoader::loadHelpers('Partial');
        return get_partial($templateName, $vars);
    }
    
    public static function localizedUrl($sf_culture = null)
    {
        if (!$sf_culture)
        {
            $sf_culture = sfContext::getInstance()->getUser()->getCulture();
        }
        
        $routing    = sfContext::getInstance()->getRouting();
        $request    = sfContext::getInstance()->getRequest();
        $controller = sfContext::getInstance()->getController();
        
        // depending on your routing configuration, you can set $route_name = $routing->getCurrentRouteName()
        $route_name = '';
        
        $parameters = $controller->convertUrlStringToParameters($routing->getCurrentInternalUri());
        $parameters[1]['sf_culture'] = $sf_culture;
        
        return $routing->generate($route_name, array_merge($request->getGetParameters(), $parameters[1]));
    }
    
    // 2 functions below are copied from EPM framework classes 
    public static function _UmlautSort($a, $b)
    {
        return self::CompareUmlaut($a[0], $b[0]);
    }
    
    /*  Input for usort() that correctly sorts German Umlauts
        Modified & bugs cleaned from PHP-User-Help of usort()
    */
    public static function CompareUmlaut($astring, $bstring)
    {
        $ALP = '0123456789AaÄäBbCcÇçDdEeFfGgĞğHhIıİiJjKkLlMmNnOoÖöPpQqRrSsŞşßTtUuÜüVvWwXxYyZz';

        if ($astring == $bstring) {
            return 0;
        }

        // find first differing char
        $aLen = strlen($astring); $bLen = strlen($bstring);
        for ($i=0; $i<$aLen && $i<$bLen && $astring[$i]==$bstring[$i]; $i++);

        // if one string is the prefix of the other one, the shorter wins
        if ($i == $aLen || $i == $bLen) {
            return (strlen($astring) < strlen($bstring)) ? -1 : 1;
        }

        // otherwise depends on the first different char
        $ALPL = strlen($ALP);
        $ap = $bp = -1;
        $j = 0;
        while (($j < $ALPL) && (($ap == -1) || ($bp == -1))) {
            if ($ALP[$j] == $astring[$i]) {
                $ap = $j;
            }
            if ($ALP[$j] == $bstring[$i]) {
                $bp = $j;
            }
            $j++;
        }
        return($ap < $bp) ? -1 : 1;
    }

/**
 * Translates a number to a short alhanumeric version
 *
 * Translated any number up to 9007199254740992
 * to a shorter version in letters e.g.:
 * 9007199254740989 --> PpQXn7COf
 *
 * specifiying the second argument true, it will
 * translate back e.g.:
 * PpQXn7COf --> 9007199254740989
 *
 * this function is based on any2dec && dec2any by
 * fragmer[at]mail[dot]ru
 * see: http://nl3.php.net/manual/en/function.base-convert.php#52450
 *
 * If you want the alphaID to be at least 3 letter long, use the
 * $pad_up = 3 argument
 *
 * In most cases this is better than totally random ID generators
 * because this can easily avoid duplicate ID's.
 * For example if you correlate the alpha ID to an auto incrementing ID
 * in your database, you're done.
 *
 * The reverse is done because it makes it slightly more cryptic,
 * but it also makes it easier to spread lots of IDs in different
 * directories on your filesystem. Example:
 * $part1 = substr($alpha_id,0,1);
 * $part2 = substr($alpha_id,1,1);
 * $part3 = substr($alpha_id,2,strlen($alpha_id));
 * $destindir = "/".$part1."/".$part2."/".$part3;
 * // by reversing, directories are more evenly spread out. The
 * // first 26 directories already occupy 26 main levels
 *
 * more info on limitation:
 * - http://blade.nagaokaut.ac.jp/cgi-bin/scat.rb/ruby/ruby-talk/165372
 *
 * if you really need this for bigger numbers you probably have to look
 * at things like: http://theserver$keys.com/php/manual/en/ref.bc.php
 * or: http://theserver$keys.com/php/manual/en/ref.gmp.php
 * but I haven't really dugg into this. If you have more info on those
 * matters feel free to leave a comment.
 *
 * @author  Kevin van Zonneveld <kevin@vanzonneveld.net>
 * @author  Simon Franz
 * @author  Deadfish
 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 * @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
 * @link    http://kevin.vanzonneveld.net/
 *
 * @param mixed   $in    String or long input to translate
 * @param boolean $to_num  Reverses translation when true
 * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
 * @param string  $passKey Supplying a password makes it harder to calculate the original ID
 *
 * @return mixed string or long
 */
    public static function alphaID($in, $to_num = false, $pad_up = false, $passKey = null)
    {
      $index = "bcdfghjkmnpqrstvwxyz0123456789BCDFGHJKLMNPQRSTVWXYZ";
      if ($passKey !== null) {
        // Although this function's purpose is to just make the
        // ID short - and not so much secure,
        // with this patch by Simon Franz (http://blog.snaky.org/)
        // you can optionally supply a password to make it harder
        // to calculate the corresponding numeric ID
     
        for ($n = 0; $n<strlen($index); $n++) {
          $i[] = substr( $index,$n ,1);
        }
     
        $passhash = hash('sha256',$passKey);
        $passhash = (strlen($passhash) < strlen($index))
          ? hash('sha512',$passKey)
          : $passhash;
     
        for ($n=0; $n < strlen($index); $n++) {
          $p[] =  substr($passhash, $n ,1);
        }
     
        array_multisort($p,  SORT_DESC, $i);
        $index = implode($i);
      }
     
      $base  = strlen($index);
     
      if ($to_num) {
        // Digital number  <<--  alphabet letter code
        $in  = strrev($in);
        $out = 0;
        $len = strlen($in) - 1;
        for ($t = 0; $t <= $len; $t++) {
          $bcpow = bcpow($base, $len - $t);
          $out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
        }
     
        if (is_numeric($pad_up)) {
          $pad_up--;
          if ($pad_up > 0) {
            $out -= pow($base, $pad_up);
          }
        }
        $out = sprintf('%F', $out);
        $out = substr($out, 0, strpos($out, '.'));
      } else {
        // Digital number  -->>  alphabet letter code
        if (is_numeric($pad_up)) {
          $pad_up--;
          if ($pad_up > 0) {
            $in += pow($base, $pad_up);
          }
        }
     
        $out = "";
        for ($t = floor(log($in, $base)); $t >= 0; $t--) {
          $bcp = bcpow($base, $t);
          $a   = floor($in / $bcp) % $base;
          $out = $out . substr($index, $a, 1);
          $in  = $in - ($a * $bcp);
        }
        $out = strrev($out); // reverse
      }
     
      return $out;
    }
    
    public static function selfURL(){
        if(!isset($_SERVER['REQUEST_URI'])){
            $serverrequri = $_SERVER['PHP_SELF'];
        }else{
            $serverrequri =    $_SERVER['REQUEST_URI'];
        }
        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
        $protocol = self::strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
        return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;   
    }

    public static function strleft($s1, $s2) {
        return substr($s1, 0, strpos($s1, $s2));
    }

    public static function flipHash($value, $reverse = false, $type_id = null)
    {
        switch ($type_id)
        {
            case PrivacyNodeTypePeer::PR_NTYP_COMPANY :
                return myTools::alphaID($value, $reverse, 4, 'HFSLRIEOGHEIROWPJGFKLJHGERUIOTHR349543Y85Y2349H93234K0DK3D3JGIREOPJG84G854P39898T2PUT894392');
                break;
            case PrivacyNodeTypePeer::PR_NTYP_GROUP :
                return myTools::alphaID($value, $reverse, 4, 'LHFJK3T34H893HOEWKP2K2KDSFH3JB923BHXJFNOFCDSLKJ3G8423HJFKDSFNWBFK8439R423HJFKWFNR33HF39DSQ5');
                break;
            case PrivacyNodeTypePeer::PR_NTYP_USER :
                return myTools::alphaID($value, $reverse, 4, 'JKS29234HT3WBDI430F34HF3IEDHJ29HS2ID34NJ5F4NJKSDEWO30843BHHJFWEO348R432HFWJK23ODS09N2DEJKW2');
                break;
            case PrivacyNodeTypePeer::PR_NTYP_PRODUCT :
                return myTools::alphaID($value, $reverse, 4, 'ESDFSD23KFKMRFT0984JWNMSDFP2M2NN490FDLLPDOSDNWM3O302882MML3345NKLMNSBAJEWEWOPFPEHRHJ30872JL');
                break;
            case PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM :
                return myTools::alphaID($value, $reverse, 4, 'P3J340N3FOINREG54GH832GDE239IDJ09FK540GJ54OIG3HO23JEKNDBWJKFBNWEPODMWMKRGNTRGTBI3UNFQBISCEW');
                break;
            case PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD :
                return myTools::alphaID($value, $reverse, 4, 'KM3D30WUF38DS2DJKBNRM2303DPPWKSSBNFOI392H2JELOPXPNQZHDFO3932JHWDOEJ32IF43KNLWPWOOIDU339778B');
                break;
            case PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT :
                return myTools::alphaID($value, $reverse, 4, '304HF3FU3UIFEGIEGFOENWEDWENPOQMSND2II2HFEIFEIU2B2NDW94578526OWWNB2U839898439JRWBWBDOO9393J2');
                break;
            case PrivacyNodeTypePeer::PR_NTYP_PLACE :
                return myTools::alphaID($value, $reverse, 4, 'FWLNF3054F3HNOF343HBG43ID4943D4PBMMKNSBWI290238D2BNCJKC3093HJFIEWF390D2BS2S0438FHFJHNJI3O38');
                break;
            case PrivacyNodeTypePeer::PR_NTYP_JOB :
                return myTools::alphaID($value, $reverse, 4, 'DLSNNBHP483DH2BDWL2P2DS0D82B2SKNWQZXMMNDNOLQDG3829FG6U3H43GHAAS9UFB2NOAO8D2NBNDO92USJ289922');
                break;
            default:
                return myTools::alphaID($value, $reverse, 4, 'NF3953J10F8KNDBW5499SBWKWNKDH57JLSJ1PFMFBSUI53MD06MSLUKE78DMEB3KLRD39UDKEDEWFWLP0348RH2DE2B');
                break;
        }
    }

    public static function pick_from_list($val, $list, $default = null)
    {
        return in_array($val, $list, true) ? $val : $default;
    }

    public static function compare_val_if_set($var, $test, $default = null)
    {
        return isset($var) ? $var == $test : $default;
    }
    
    public static function sortResumeItems($a, $b)
    {
        if ($a->getDateFrom('U') == $b->getDateFrom('U')) return 0;
        return $a->getDateFrom('U') > $b->getDateFrom('U') ? -1 : 1;
    }
    
    public static function fixInt($val)
    {
        if (is_array($val))
        {
            return array_map(create_function('$value', 'return (int)$value;'), $val);
        }
        return is_null($val) || $val === '' ? null : intval($val); 
    }
    
    public static function hashCustomer($cus_id, $cus_type_id = null, $decode = false)
    {
        return $decode ? base64_decode($cus_id) : base64_encode("$cus_id|$cus_type_id");
    }
    
    public static function unplug($plug, $return_object = true)
    {
        $psplit = explode('|', base64_decode($plug));
        if (is_array($psplit) && ($psplit[0] = intval($psplit[0])) && in_array($psplit[0], array(PrivacyNodeTypePeer::PR_NTYP_USER, PrivacyNodeTypePeer::PR_NTYP_COMPANY, PrivacyNodeTypePeer::PR_NTYP_GROUP, PrivacyNodeTypePeer::PR_NTYP_PRODUCT, PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM, PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD, PrivacyNodeTypePeer::PR_NTYP_EVENT, PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT, PrivacyNodeTypePeer::PR_NTYP_PLACE, PrivacyNodeTypePeer::PR_NTYP_JOB, PrivacyNodeTypePeer::PR_NTYP_PUBLICATION)))
        {
            $id = myTools::flipHash($psplit[1], true, $psplit[0]);
            return $return_object ? PrivacyNodeTypePeer::retrieveObject($id, $psplit[0]) : array($psplit[0], $id);
        }
        return null;
    }

    public static function remove_querystring_var($url, $key, $val = null, $append = null)
    {
        $keys = is_array($key) ? $key : array($key);
        $vals = is_array($val) ? $val : array_filter(array($val));
        foreach ($keys as $ind => $key)
        {
            $val = count($vals) ? $vals[$ind] : '';
            $key = str_replace('[]', '\[\]', $key);
            $url = str_replace('%5B%5D', '[]', $url);
            $url = preg_replace(!$val ? "/($key=[^&]*&)|([&]$key=[^&]*)|((?)$key=[^&]*[&])|([?]$key=[^&]*$)/iu"
                                    : "/($key=$val&)|([&]$key=$val)|((?)$key={$val}[&])|([?]$key={$val}$)/iu", '', $url);
        }
        if ($append)
        {
            $append = is_array($append) ? http_build_query($append) : $append;
            $url = (strpos($url, '?') !== false ? "$url&$append" : "$url?$append");
        }
        return $url; 
    }

    public static function executeSql($sql, $useTransaction = true, $return_array = false)
    {
        $con = Propel::getConnection();
        try {
            $con->beginTransaction();
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return $return_array ? $stmt->fetchAll(PDO::FETCH_NUM) : $stmt;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    public static function ucfirst_utf8($str) {
        if (mb_check_encoding($str,'UTF-8'))
        {
            $first = mb_substr(mb_strtoupper($str, "utf-8"), 0, 1, 'utf-8');
            return $first . mb_substr(mb_strtolower($str, "utf-8"), 1, mb_strlen($str), 'utf-8');
        }
        else
        {
            return $str;
        }
    } 
    
    public static function getInitial($str, $capitalize = false) {
        if (mb_check_encoding($str,'UTF-8'))
        {
            return  mb_substr($capitalize ? mb_strtoupper($str, "utf-8") : $str, 0, 1, 'utf-8');
        }
        else
        {
            return substr($str, 0, 1);
        }
    } 

    public static function NLSFunc($column, $nls_function = 'UPPER', $culture = null)
    {
        $glue = $nls_function == 'SORT' ? '' : "_";
        $cult = $culture ? $culture : sfContext::getInstance()->getUser()->getCulture();
        if ($cult != 'en')
        {
            sfLoader::loadHelpers('I18n');
            return "NLS$glue$nls_function($column,'NLS_SORT=".(format_language($cult, 'en'))."')";
        }
        else
        {
            $func = $nls_function == 'SORT' ? '' : $nls_function;
            return "$func($column)";
        }
    }
    
    public static function injectParameter($url, $parameter)
    {
        if (strpos($url, '?') !== false)
        {
            if (!is_array($parameter)) parse_str($parameter, $parameter);
            foreach ($parameter as $key => $val)
            {
                $url = self::remove_querystring_var($url, $key);
            }
            return strpos($url, '?') === false ? $url.'?'.http_build_query($parameter) : $url.'&'.http_build_query($parameter);
        }
        else
        {
            return $url . '?' . (is_array($parameter) ? http_build_query($parameter) : $parameter); 
        }
    }
}
