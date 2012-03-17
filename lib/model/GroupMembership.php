<?php

class GroupMembership extends BaseGroupMembership
{
    private $member_object = null;
    
    public function getInviter()
    {
        switch ($this->getInviterTypeId())
        {
            case PrivacyNodeTypePeer::PR_NTYP_USER :
                return UserPeer::retrieveByPK($this->getInviterId());
                break;
            case PrivacyNodeTypePeer::PR_NTYP_COMPANY :
                return CompanyPeer::retrieveByPK($this->getInviterId());
                break;
            case PrivacyNodeTypePeer::PR_NTYP_GROUP :
                return GroupPeer::retrieveByPK($this->getInviterId());
                break;
            default: return null;
        }
        return null;
    }
    
    public function getMember()
    {
        if (!$this->member_object)
        {
            $this->member_object = PrivacyNodeTypePeer::retrieveObject($this->getObjectId(), $this->getObjectTypeId());
        }
        return $this->member_object;
    }
    
    public function getRelationUpdate()
    {
        $c = new Criteria();
        $c->add(RelationUpdatePeer::OBJECT_ID, $this->getGroupId());
        $c->add(RelationUpdatePeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $c->add(RelationUpdatePeer::SUBJECT_ID, $this->getObjectId());
        $c->add(RelationUpdatePeer::SUBJECT_TYPE_ID, $this->getObjectTypeId());
        $c->addDescendingOrderByColumn(RelationUpdatePeer::CREATED_AT);
        $upd = RelationUpdatePeer::doSelectOne($c);
        return ($upd && $upd->getStatus() === RelationUpdatePeer::RU_STATUS_PENDING) ? $upd : null;
    }
}
