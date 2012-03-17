<?php

class SecretHub
{
    
    private static function convert($seed, $salt)
    {
        return hash_hmac('ripemd160', 'All the way down to Alaska we have gone.', "$salt-$seed");
    }
    
    public static function issue($seeds, $clear = true)
    {
        $resecrets = array();
        if ($clear)
        {
            $secrets = array();
            sfContext::getInstance()->getUser()->setAttribute('secrets', $secrets, '/myemt/account/secrets');
        }
        else
        {
            $secrets = sfContext::getInstance()->getUser()->getAttribute('secrets', array(), '/myemt/account/secrets');
        }
        
        $seeds = is_array($seeds) ? $seeds : array($seeds);
        
        $salt = uniqid();
        foreach ($seeds as $key => $seed)
        {
            $secret = self::convert($seed, $salt);
            $resecrets[$key] = $secret;
            $secrets[$secret] = $salt;
        }
        sfContext::getInstance()->getUser()->setAttribute('secrets', $secrets, '/myemt/account/secrets');
        return count($resecrets) === 1 ? $resecrets[0] : $resecrets;
    }
    
    public static function validate($secret, $seed)
    {
        $secrets = sfContext::getInstance()->getUser()->getAttribute('secrets', array(), '/myemt/account/secrets');
        
        if (isset($secrets[$secret]) && self::convert($seed, ($salt = $secrets[$secret])) === $secret)
        {
            foreach ($secrets as $key => $val)
            {
                if ($val == $salt) unset($secrets[$key]);
            }
            sfContext::getInstance()->getUser()->setAttribute('secrets', $secrets, '/myemt/account/secrets');
            return true;
        }
        return false;
    }
    
    public static function impl($items)
    {
        return implode('-', func_get_args());
    }
    
}
?>