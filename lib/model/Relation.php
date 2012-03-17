<?php

class Relation extends BaseRelation
{
    public function getRelationUpdate()
    {
        $c = new Criteria();
        $c->add(RelationUpdatePeer::OBJECT_ID, $this->getRelatedUserId());
        $c->add(RelationUpdatePeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(RelationUpdatePeer::SUBJECT_ID, $this->getUserId());
        $c->add(RelationUpdatePeer::SUBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(RelationUpdatePeer::STATUS, RelationUpdatePeer::RU_STATUS_PENDING);
        $c->addDescendingOrderByColumn(RelationUpdatePeer::CREATED_AT);
        return RelationUpdatePeer::doSelectOne($c);
    }
}
