<?php

class ClientUserPeer extends BaseClientUserPeer
{
    
    public static function retrieveUser()
    {
        $device = ClientDevicePeer::retrieveDevice();
        $sesuser = sfContext::getInstance()->getUser()->getUser();
        
        if ($device)
        {
            $user = $device->getClientUserByUserId($sesuser ? $sesuser->getId() : null);
        }
        else
        {
            return null;
        }
        
        if (!$user)
        {
            $user = $device->addUser($sesuser ? $sesuser->getId() : null);
        }
        
        return $user;
    }

}
