<?php

class InviteFriend extends BaseInviteFriend
{
    public function getInviter()
    {
        switch ($this->getInviterTypeId())
        {
            case PrivacyNodeTypePeer::PR_NTYP_USER :
                return UserPeer::retrieveByPK($this->getInviterId());
                break;
            case PrivacyNodeTypePeer::PR_NTYP_GROUP :
                return GroupPeer::retrieveByPK($this->getInviterId());
                break;
        }
    }

    public function getInvitedToObject()
    {
        switch ($this->getInvitedToTypeId())
        {
            case PrivacyNodeTypePeer::PR_NTYP_USER :
                return UserPeer::retrieveByPK($this->getInvitedToId());
                break;
            case PrivacyNodeTypePeer::PR_NTYP_GROUP :
                return GroupPeer::retrieveByPK($this->getInvitedToId());
                break;
        }
    }
    
    public function getEmailTransaction($last = true)
    {
        $c = new Criteria();
        $c->add(EmailTransactionPeer::EMAIL, $this->getEmail());
        $c->add(EmailTransactionPeer::DATA, '%s:11:"invite_guid";s:32:"'.$this->getGuid().'";%', Criteria::LIKE);
        $c->addDescendingOrderByColumn(EmailTransactionPeer::CREATED_AT);
        $trs = EmailTransactionPeer::doSelect($c);
        return ($last && count($trs)) ? $trs[0] : $trs;
    }
}
