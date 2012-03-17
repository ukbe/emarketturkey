<?php

class InviteFriendPeer extends BaseInviteFriendPeer
{
    public static function retrieveByGuid($guid)
    {
        $c = new Criteria();
        $c->add(InviteFriendPeer::GUID, $guid);
        return InviteFriendPeer::doSelectOne($c);
    }
}
