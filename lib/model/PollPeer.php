<?php

class PollPeer extends BasePollPeer
{
    CONST PL_TYP_PUBLIC     = 1;
    CONST PR_TYP_PRIVATE    = 2;
    
    public static $typeNames    = array (1 => 'Public',
                                         2 => 'Private',
                                         );
    
    CONST PL_STAT_ACTIVE    = 1;
    CONST PR_STAT_PASSIVE   = 2;
    
    public static $statusNames  = array (1 => 'Active',
                                         2 => 'Passive',
                                         );
    
    public static function retrieveByGuid($guid)
    {
        $c = new Criteria();
        $c->add(PollPeer::GUID, $guid);
        return PollPeer::doSelectOne($c);
    }
    
    public static function prepareCookie()
    {
        $cookie = sfContext::getInstance()->getRequest()->getCookie('POLL');
        
        if (!$cookie && sfContext::getInstance()->getRequest()->getParameter('fci')=='')
        {
            $client_dev = new ClientDevice();
            $client_dev->setIp($_SERVER['REMOTE_ADDR']);
            $client_dev->save();
            
            sfContext::getInstance()->getResponse()->setCookie('POLL', $client_dev->getHash());
            $vars = $_GET;
            $vars['fci'] = true;
            header('Location:/'.($_SERVER['HTTPS']!=''?"https://":"http://").$_SERVER['SERVER_NAME']."/".$_SERVER['REQUEST_URI'].'?'.http_build_query($vars));
        }
        return $cookie;
    }
    
}
