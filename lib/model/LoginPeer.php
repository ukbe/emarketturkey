<?php

class LoginPeer extends BaseLoginPeer
{
    public static function retrieveByGuid($guid)
    {
        $c = new Criteria();
        $c->add(LoginPeer::GUID, $guid);
        return LoginPeer::doSelectOne($c);
    }
}
