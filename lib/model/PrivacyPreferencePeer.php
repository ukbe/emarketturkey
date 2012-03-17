<?php

class PrivacyPreferencePeer extends BasePrivacyPreferencePeer
{
    public static function retrieveByObject($object_id, $object_type_id, $actions = NULL, $get_only_controllables = false, $role_on_object = null, $subject_type_id = null, $role_on_subject = null)
    {
        $acts = array();

        if (is_array($actions) && count($actions))
        {
            if ($actions[0] instanceof Action)
            {
                foreach ($actions as $action)
                {
                    $acts[] = $action->getId();
                }
                $acts = implode(',', $acts);
            }
            else
            {
                $acts = implode(',', $actions);
            }
        }
        else
        {
            $acts = $actions;
        }

        $sql = "
        SELECT * FROM EMT_PRIVACY_PREFERENCE PR
        " . ($get_only_controllables ? "LEFT JOIN EMT_ACTION ON PR.ACTION_ID=EMT_ACTION.ID" : "") . "
        
        LEFT JOIN
        (
            select connect_by_root id spoint, id, sysname, level lvl from emt_role
            start with parent_id is not null
            connect by nocycle prior parent_id = id
        ) sroles ON PR.ROLE_ON_OBJECT=sroles.SPOINT

        WHERE 
        (
            (OBJECT_TYPE_ID=$object_type_id AND OBJECT_ID=$object_id) OR (OBJECT_TYPE_ID=$object_type_id AND OBJECT_ID IS NULL)
        )
        " . ($acts ? "AND ACTION_ID IN ($acts)" : "") . "
        " . ($get_only_controllables ? "AND EMT_ACTION.PRIVACY_CONTROLLED=1" : "") . "
        " . ($subject_type_id ? "AND (PR.SUBJECT_TYPE_ID=$subject_type_id OR PR.SUBJECT_TYPE_ID IS NULL)" : "") . "
        " . ($role_on_object ? "AND (PR.ROLE_ON_OBJECT=$role_on_object OR PR.ROLE_ON_OBJECT IS NULL)" : "") . "
        " . ($role_on_subject ? "AND (PR.ROLE_ON_SUBJECT=$role_on_subject OR PR.ROLE_ON_SUBJECT IS NULL)" : "") . "
        ORDER BY OBJECT_ID DESC, SROLES.LVL 
        ";
        
        $con = Propel::getConnection();

        $stmt = $con->prepare($sql);
        $stmt->execute();
        $prs = PrivacyPreferencePeer::populateObjects($stmt);
        return count(explode(',', $acts)) == 1 ? (count($prs) ? $prs[0] : null) : $prs; 
    }

    public static function retrieveByRelation($subject_id, $subject_type_id, $object_id, $object_type_id, $actions = NULL, $get_only_controllables = false)
    {
        $acts = array();

        if (is_array($actions) && count($actions))
        {
            if ($actions[0] instanceof Action)
            {
                foreach ($actions as $action)
                {
                    $acts[] = $action->getId();
                }
                $acts = implode(',', $acts);
            }
            else
            {
                $acts = implode(',', $actions);
            }
        }
        else
        {
            $acts = $actions;
        }

        $sql = "
SELECT * FROM
(
    SELECT RES.*, RANK() OVER (PARTITION BY ACTION_ID ORDER BY P_RLVL, S_RLVL, OBJECTED, P_SUBJECT_ID) UNIACT FROM 
    (
        SELECT pp.*, assig.*  FROM
        (
            SELECT CONNECT_OBJECT_ID, CONNECT_OBJECT_TYPE_ID, CONNECT_ROLE_ID, SROLES.ID S_ROLE_ID, SROLES.LVL S_RLVL, P_OBJECT_ID, P_OBJECT_TYPE_ID, P_SUBJECT_ID, P_SUBJECT_TYPE_ID, OROLES.ID P_ROLE_ID, OROLES.LVL P_RLVL FROM 
            (
                SELECT CONNECT_BY_ROOT P_OBJECT_ID CONNECT_OBJECT_ID, CONNECT_BY_ROOT P_OBJECT_TYPE_ID CONNECT_OBJECT_TYPE_ID, CONNECT_BY_ROOT T_ROLE_ID CONNECT_ROLE_ID , RELS.*, LEVEL DEPTH
                FROM 
                (
                    SELECT 
                        OBJECT_ID P_OBJECT_ID, 
                        1 P_OBJECT_TYPE_ID, 
                        SUBJECT_ID P_SUBJECT_ID, 
                        1 P_SUBJECT_TYPE_ID, 
                        ROLE_ID T_ROLE_ID
                    FROM 
                    (
                        SELECT USER_ID SUBJECT_ID, RELATED_USER_ID OBJECT_ID, ROLE_ID FROM
                        (
                          SELECT * FROM EMT_RELATION_VIEW WHERE STATUS=".RelationPeer::RL_STAT_ACTIVE."
                          
                          UNION ALL
                          
                          SELECT ID, RELATED_USER_ID USER_ID, COMPANY_ID, USER_ID RELATED_USER_ID, RELATED_COMPANY_ID, ROLE_ID, STATUS, CREATED_AT, UPDATED_AT, SEQNUMBER FROM EMT_RELATION_VIEW WHERE STATUS=".RelationPeer::RL_STAT_ACTIVE."
                        )
                    )
                
                    UNION ALL 
                
                    SELECT 
                        GROUP_ID P_OBJECT_ID, 
                        ".PrivacyNodeTypePeer::PR_NTYP_GROUP." P_OBJECT_TYPE_ID, 
                        OBJECT_ID P_SUBJECT_ID, 
                        OBJECT_TYPE_ID P_SUBJECT_TYPE_ID, 
                        ROLE_ID T_ROLE_ID
                    FROM EMT_GROUP_MEMBERSHIP_VIEW 
                    WHERE STATUS=1
              
                    UNION ALL
              
                    SELECT 
                        OBJECT_ID P_OBJECT_ID, 
                        OBJECT_TYPE_ID P_OBJECT_TYPE_ID, 
                        GROUP_ID P_SUBJECT_ID, 
                        ".PrivacyNodeTypePeer::PR_NTYP_GROUP." P_SUBJECT_TYPE_ID, 
                        CASE
                            WHEN ROLE_ID=".RolePeer::RL_GP_MEMBER." THEN ".RolePeer::RL_MEMBERED_GROUP."
                            WHEN ROLE_ID=".RolePeer::RL_GP_FOLLOWER." THEN ".RolePeer::RL_FOLLOWED_GROUP."
                            ELSE ROLE_ID
                        END T_ROLE_ID
                    FROM EMT_GROUP_MEMBERSHIP_VIEW
                    WHERE STATUS=".GroupMembershipPeer::STYP_ACTIVE."
        
                    UNION ALL 
                
                    SELECT 
                        COMPANY_ID P_OBJECT_ID, 
                        ".PrivacyNodeTypePeer::PR_NTYP_COMPANY." P_OBJECT_TYPE_ID, 
                        OBJECT_ID P_SUBJECT_ID, 
                        OBJECT_TYPE_ID P_SUBJECT_TYPE_ID, 
                        ROLE_ID T_ROLE_ID
                    FROM EMT_COMPANY_USER_VIEW
                    WHERE STATUS=".CompanyUserPeer::CU_STAT_ACTIVE."
        
                    UNION ALL
        
                    SELECT 
                        OBJECT_ID P_OBJECT_ID, 
                        OBJECT_TYPE_ID P_OBJECT_TYPE_ID, 
                        COMPANY_ID P_SUBJECT_ID, 
                        ".PrivacyNodeTypePeer::PR_NTYP_COMPANY." P_SUBJECT_TYPE_ID, 
                        CASE
                        WHEN ROLE_ID=".RolePeer::RL_CM_PARENT_COMPANY." THEN ".RolePeer::RL_CM_SUBSIDIARY_COMPANY."
                        WHEN ROLE_ID=".RolePeer::RL_CM_SUBSIDIARY_COMPANY." THEN ".RolePeer::RL_CM_PARENT_COMPANY."
                        ELSE ROLE_ID
                        END T_ROLE_ID
                    FROM EMT_COMPANY_USER_VIEW
                    WHERE STATUS=".CompanyUserPeer::CU_STAT_ACTIVE."
        
                ) RELS
                START WITH P_SUBJECT_ID=$subject_id AND P_SUBJECT_TYPE_ID=$subject_type_id
                CONNECT BY NOCYCLE (PRIOR P_OBJECT_ID=P_SUBJECT_ID AND PRIOR P_OBJECT_TYPE_ID=P_SUBJECT_TYPE_ID AND LEVEL < 3 AND (P_OBJECT_ID!=$subject_id OR P_OBJECT_TYPE_ID!=$subject_type_id))
            ) fs
            LEFT JOIN
            (
                select connect_by_root id spoint, id, sysname, level lvl from emt_role
                start with parent_id is not null
                connect by nocycle prior parent_id = id
            ) oroles ON FS.T_ROLE_ID=oroles.SPOINT
            LEFT JOIN
            (
                select connect_by_root id spoint, id, sysname, level lvl from emt_role
                start with parent_id is not null
                connect by nocycle prior parent_id = id
            ) sroles ON FS.CONNECT_ROLE_ID=sroles.SPOINT
        ) assig, 
        (
            select 
                emt_privacy_preference.*, 
                CASE
                    WHEN (coalesce(subject_id, 0) * coalesce(object_id, 0) > 0) THEN 1
                    WHEN coalesce(object_id, 0) < coalesce(subject_id, 0) THEN 2
                    ELSE 3
                END objected 
            from emt_privacy_preference
        ) pp
        
        order by p_rlvl, s_rlvl, objected, p_subject_id
    ) res
    " . ($get_only_controllables ? "LEFT JOIN EMT_ACTION ON ACTION_ID=EMT_ACTION.ID" : "") . "
    WHERE 
    (
      (
        ((p_subject_id=subject_id and subject_type_id=p_subject_type_id) or subject_id is null)
        and 
        ((p_object_id=object_id and object_type_id=p_object_type_id) or object_id is null)
      )  
      and 
      ((p_role_id=role_on_object and p_object_type_id=object_type_id) or (role_on_object is null and p_rlvl=1))
      and 
      ((s_role_id=role_on_subject and p_subject_type_id=subject_type_id) or (role_on_subject is null and s_rlvl=1))
      and 
      (p_object_type_id is not null)
      and 
      (
        (p_subject_id=$subject_id and subject_type_id=$subject_type_id and p_object_id=$object_id and p_object_type_id=$object_type_id) or
        (p_subject_id is null and p_role_id=".RolePeer::RL_ALL." and subject_type_id=$subject_type_id and p_object_id=$object_id and p_object_type_id=$object_type_id and rownum=1)
      )
      " . ($acts ? "AND EMT_ACTION.ID IN ($acts)" : "") . "
      " . ($get_only_controllables ? "AND EMT_ACTION.PRIVACY_CONTROLLED=1" : "") . "
    )
)
WHERE UNIACT=1
        ";
        $con = Propel::getConnection();

        $stmt = $con->prepare($sql);
        $stmt->execute();
        return PrivacyPreferencePeer::populateObjects($stmt);
    }
}
