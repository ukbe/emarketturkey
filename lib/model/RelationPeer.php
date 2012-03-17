<?php

class RelationPeer extends BaseRelationPeer
{
    CONST RL_STAT_PENDING_CONFIRMATION      = 1;
    CONST RL_STAT_ACTIVE                    = 2;
    CONST RL_STAT_REJECTED                  = 3;
    CONST RL_STAT_ENDED_BY_TARGET_USER      = 4;
    CONST RL_STAT_ENDED_BY_STARTER_USER     = 5;

    public static function setupRelation(sfParameterHolder $relation_prefs)
    {
        $user = UserPeer::retrieveByPK($relation_prefs->get('user_id'));
        if ($user)
        {
            if (!$user->isFriendsWith($relation_prefs->get('related_user_id')))
            {
                $relation = $user->setupRelationWith($relation_prefs->get('related_user_id'), $relation_prefs->get('status'), $relation_prefs->get('role_id'));
                return $relation;
            }
        }
        return null;
    }
}
