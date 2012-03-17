<?php

class RolePeer extends BaseRolePeer
{
    // Global Roles
    CONST EMT_EVERYONE          = 1;
    CONST EMT_ADMIN             = 2;
    CONST EMT_USER              = 3;
    CONST EMT_COMPANY           = 4;
    CONST EMT_ANONYMOUS         = 5;
    CONST EMT_INDIVIDUAL        = 6;
    CONST EMT_AUTHOR            = 7;
    CONST EMT_TRANSLATOR        = 8;
    CONST EMT_EDITOR            = 9;
    CONST EMT_OWNER             = 10;
    CONST EMT_REPRESENTATIVE    = 11;

    // Company Related Roles
    CONST CMP_OWNER             = 30;
    CONST CMP_HRREP             = 31;
    CONST CMP_FINREP            = 32;
    CONST CMP_CORPREP           = 33;

    // Group Related Roles
    CONST GRP_OWNER             = 20;
    CONST GRP_MOD               = 21;
    CONST GRP_MEMBER            = 22;
    
    CONST RL_SELF               = 0;
    CONST RL_USER               = 1;
    CONST RL_ADMIN              = 2;
    CONST RL_AUTHOR             = 3;
    CONST RL_REPRESENTATIVE     = 4;
    CONST RL_TRANSLATOR         = 5;
    CONST RL_EDITOR             = 6;
    CONST RL_CM_ALL             = 7;
    CONST RL_CM_OWNER           = 8;
    CONST RL_CM_REPRESENTATIVE  = 9;
    CONST RL_CM_FOLLOWER        = 10;
    CONST RL_GP_ALL             = 11;
    CONST RL_GP_MEMBER          = 12;
    CONST RL_GP_OWNER           = 13;
    CONST RL_GP_MODERATOR       = 14;
    CONST RL_NETWORK_MEMBER     = 15;
    CONST RL_FAMILY_MEMBER      = 16;
    CONST RL_SPOUSE             = 17;
    CONST RL_SIBLING            = 18;
    CONST RL_COLLEGUE           = 19;
    CONST RL_CM_PARTNER         = 20;
    CONST RL_ALL                = 21;
    CONST RL_GP_OFFICIAL_MEMBER         = 22;
    CONST RL_GP_OFFICIAL_CONTRIBUTER    = 23;
    CONST RL_CANDIDATE_NETWORK_MEMBER   = 24;
    CONST RL_GP_CANDIDATE_MEMBER        = 25;
    CONST RL_SCHOOLMATE                 = 26;
    CONST RL_GP_FOLLOWER                = 27;
    CONST RL_GP_CANDIDATE_LINKED_GROUP  = 28;
    CONST RL_GP_LINKED_GROUP            = 29;
    CONST RL_GP_PARENT_GROUP            = 30;  // this is a reverse role for RL_GP_SUBSIDIARY_GROUP
    CONST RL_GP_SUBSIDIARY_GROUP        = 31;  // this is a reverse role for RL_GP_PARENT_GROUP
    CONST RL_CM_PARENT_COMPANY          = 32;  // this is a reverse role for RL_CM_SUBSIDIARY_COMPANY
    CONST RL_CM_SUBSIDIARY_COMPANY      = 33;  // this is a reverse role for RL_CM_PARENT_COMPANY
    CONST RL_COMPANY                    = 34;
    CONST RL_GROUP                      = 35;
    CONST RL_FOLLOWED_COMPANY           = 36;  // this is a reverse role for RL_CM_FOLLOWER
    CONST RL_FOLLOWED_GROUP             = 37;  // this is a reverse role for RL_GP_FOLLOWER
    CONST RL_MEMBERED_GROUP             = 38;  // this is a reverse role for RL_GP_MEMBER

    public static function getRolesRelatedTo($object_type = null, $subject_type = null)
    {
        $c = new Criteria();
        $c->addJoin(RoleMatrixPeer::ID, RolePeer::ID, Criteria::LEFT_JOIN);
        if (isset($object_type)) $c->add(RoleMatrixPeer::OBJECT_TYPE_ID, $object_type);
        if (isset($subject_type)) $c->add(RoleMatrixPeer::SUBJECT_TYPE_ID, $subject_type);
        $c->add(RoleMatrixPeer::IS_RELATION_TYPE, true);
        $c->addAscendingOrderByColumn(RoleI18nPeer::NAME);
        return RolePeer::doSelectWithI18n($c);
    }
    
    public static function getSysnameFor($role_ids)
    {
        $role_ids = is_array($role_ids) ? $role_ids : array($role_ids);
        $c = new Criteria();
        $c->addSelectColumn(RolePeer::ID);
        $c->addSelectColumn(RolePeer::SYSNAME);
        $c->add(RolePeer::ID, $role_ids, Criteria::IN);
        $stmt = BasePeer::doSelect($c);
        $rows = array();
        while ($row = $stmt->fetch(PDO::FETCH_NUM))
        {
            $rows[$row[0]] = $row[1];
        }
        
        return $rows;
    }

    public static function retrieveBySysname($sysname)
    {
        $isarray = is_array($sysname);
        $c = new Criteria();
        $c->add(RolePeer::SYSNAME, $sysname, $isarray ? Criteria::IN : Criteria::EQUAL);
        return $isarray ? self::doSelect($c) : self::doSelectOne($c);
    }

}
