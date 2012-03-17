<?php

class ClientDevice extends BaseClientDevice
{
    public function getClientUserByUserId($userid)
    {
        $c = new Criteria();
        if ($userid)
        {
            $c->add(ClientUserPeer::USER_ID, $userid);
        }
        else
        {
            $c->add(ClientUserPeer::USER_ID, null, Criteria::ISNULL);
        }
        $c->setLimit(1);
        $users = $this->getClientUsers($c);
        return count($users) ? $users[0] : null;
    }
    
    public function addUser($userid=null)
    {
        $user = new ClientUser();
        $user->setClientDeviceId($this->getId());
        $user->setUserId($userid);
        $user->save();
        return $user;
    }
    
}
