<?php

class ClientDevicePeer extends BaseClientDevicePeer
{
    public static function retrieveByHash($hash, $ip = null)
    {
        if (!$hash) return null;
        $c = new Criteria();
        $c->add(ClientDevicePeer::HASH, $hash);
        if (!is_null($ip)) $c->add(ClientDevicePeer::IP, ip2long($ip));
        return ClientDevicePeer::doSelectOne($c);
    }

    public static function retrieveDevice()
    {
        $context = sfContext::getInstance();
        
        $hash = $context->getRequest()->getCookie('vimc');
        // First check if the client device exists with hash and ip
        $c = new Criteria();
        if ($hash!='')
        {
            $c->add(ClientDevicePeer::HASH, $hash);
        }
        else
        {
            $c->add(ClientDevicePeer::HASH, null, Criteria::ISNULL);
        }
        $c->add(ClientDevicePeer::IP, ip2long($_SERVER['REMOTE_ADDR']));
        $device = ClientDevicePeer::doSelectOne($c);
        
        // if device doesn't exist but hash record exists, then create a new device with existing hash 
        if (!$device && $hash && ($hashdevice = ClientDevicePeer::retrieveByHash($hash)))
        {
            $device = new ClientDevice();
            $device->setHash($hash);
            $device->setIp(ip2long($_SERVER['REMOTE_ADDR']));
            $device->save();
            return $device;
        }
        elseif ($device)
        {
            return $device;
        }
        else
        {
            if (sfContext::getInstance()->getUser()->getAttribute('hash')=='')
            {
                $con = Propel::getConnection();
                $sql = "SELECT sys_guid() FROM DUAL";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                $newhash = $stmt->fetch(PDO::FETCH_COLUMN, 0);
                $context->getUser()->setAttribute('hash', $newhash);
                setcookie('vimc', $newhash, time()+60*60*24*365, '/');
                header('Location:'.(isset($_SERVER['HTTPS'])?"https://":"http://").$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].(count($_GET) ? '?'.http_build_query($_GET) : ''));
            }
            else
            {
                $hash = ($context->getUser()->getAttribute('hash') === $context->getRequest()->getCookie('vimc') ? $context->getUser()->getAttribute('hash') : '');
                $context->getUser()->setAttribute('hash', '');
                if ($hash == '')
                {
                    $device = ClientDevicePeer::retrieveByIP(ip2long($_SERVER['REMOTE_ADDR']));
                    if ($device) return $device;
                }
                $device = new ClientDevice();
                $device->setIp(ip2long($_SERVER['REMOTE_ADDR']));
                $device->setHash($hash);
                $device->save();
                return $device;
            }
        }
        return null;
    }

    /*
     * Use this function only if you're sure that client doesn't support cookies
     */
    public static function retrieveByIP($ip)
    {
        $c = new Criteria();
        $c->add(ClientDevicePeer::IP, ip2long($ip));
        $c->add(ClientDevicePeer::HASH, null, Criteria::ISNULL);
        return ClientDevicePeer::doSelectOne($c);
    }
    
}
