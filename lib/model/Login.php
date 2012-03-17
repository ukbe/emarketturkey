<?php

class Login extends BaseLogin
{
    public function setPassword($password)
    {
        $salt = md5(rand(100000, 999999).$this->getEmail().$this->getUsername());
        $this->setSalt($salt);
        $this->setSha1Password(sha1($salt.$password));
    }

    public function getRoles()
    {
        $c = new Criteria();
        $c->addJoin(RolePeer::ID, RoleAssignmentPeer::ROLE_ID, Criteria::RIGHT_JOIN);
        $c->add(RoleAssignmentPeer::LOGIN_ID, $this->getId());
        return RolePeer::doSelect($c);
    }
    
    public function getRoleNames($sysnames = true)
    {
        $roles = $this->getRoles();
        $names = array();
        foreach ($roles as $role) array_push($names, ($sysnames?$role->getSysName():$role->getName()));
        return $names;
    }
    
        public function getUser()
    {
        $c = new Criteria();
        $c->add(UserPeer::LOGIN_ID, $this->getId());
        return UserPeer::doSelectOne($c);
    }
    
    public function checkPassword($password)
    {
        return (sha1($this->getSalt().$password) == $this->getSha1Password()); 
    }
    
    public function hasUsername()
    {
        return  ($this->getUsername()!='' && !is_null($this->getUsername()));
    }
    
    public function getPasswordResetRequest($reqguid)
    {
        $c = new Criteria();
        $c->add(PasswordResetRequestPeer::GUID, $reqguid);
        $reqs = $this->getPasswordResetRequests($c);
        return count($reqs)?$reqs[0]:null;
    }
    
    public function isBlocked()
    {
        $c = new Criteria();
        $c->add(BlocklistPeer::ACTIVE, 1);
        $this->countBlocklists($c);
    }

    public function isVerified()
    {
        $c = new Criteria();
        $c->add(BlocklistPeer::ACTIVE, 1);
        $c->add(BlocklistPeer::BLOCKREASON_ID, BlockReasonPeer::BR_TYP_VERIFICATION_REQUIRED);
        return ($this->countBlocklists($c) == 0);
    }

    public function countBlocksExceptReasonIds($rsnids)
    {
        $c = new Criteria();
        $c->add(BlocklistPeer::ACTIVE, 1);
        $c->add(BlocklistPeer::BLOCKREASON_ID, $rsnids, Criteria::NOT_IN);
        $this->countBlocklists($c);
    }

    public function getBlockByReasonId($rsnid)
    {
        $c = new Criteria();
        $c->add(BlocklistPeer::ACTIVE, 1);
        $c->add(BlocklistPeer::BLOCKREASON_ID, $rsnid);
        $blks = $this->getBlocklists($c);
        return count($blks) ? $blks[0] : $blks;
    }
}
