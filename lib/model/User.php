<?php

class User extends BaseUser
{
    protected $aSentMessages=null;
    protected $aReceivedMessages=null;
    protected $aArchivedMessages=null;
    protected $UnreadMessageCount=null;
    protected $ownerships=null;

    private $hash = null;
    
    public function __toString()
    {
        return $this->getDisplayName() . ' ' . $this->getDisplayLastname(); 
    }
    
    public function setName($name)
    {
        parent::setName($name);
        
        $this->setDisplayName(mb_convert_case(trim($this->getName()), MB_CASE_TITLE, "UTF-8"));
    }

    public function setLastname($lastname)
    {
        parent::setLastname($lastname);
        
        $this->setDisplayLastname(mb_convert_case(trim($this->getLastname()), MB_CASE_TITLE, "UTF-8"));
    }
    
    public function updateDisplayName()
    {
        $this->setDisplayName(mb_convert_case(trim($this->getName()), MB_CASE_TITLE, "UTF-8"));
        $this->setDisplayLastname(mb_convert_case(trim($this->getLastname()), MB_CASE_TITLE, "UTF-8"));
    }

    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_USER;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_USER) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getManageUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . "homepage";  
    }
    
    public function getResumeById($resume_id)
    {
        $c = new Criteria();
        $c->add(ResumePeer::ID, $resume_id);
        $c->add(ResumePeer::USER_ID, $this->getId());
        return ResumePeer::doSelectOne($c);
    }
    
    public function getResume()
    {
        $c = new Criteria();
        $c->setLimit(1);
        $resumes = User::getResumes($c);
        return count($resumes)?$resumes[0]:null;
    }
    
    public function getUnreadMessageCount($include_involved=false)
    {
        if ($include_involved)
        {
            $companies = $this->getCompanies();
            $ids = array();
            foreach ($companies as $company)
            {
                $ids[] = $company->getId();
            }
            $ids = count($companies) ? '('. implode(',', $ids) . ')' : null;
        }
        
        $con = Propel::getConnection();
        
        $sql = "SELECT count(*) FROM ".MessageRecipientPeer::TABLE_NAME."
                LEFT JOIN ".UserPeer::TABLE_NAME." ON ".MessageRecipientPeer::RECIPIENT_ID."=".UserPeer::ID." 
                LEFT JOIN ".CompanyPeer::TABLE_NAME." ON ".MessageRecipientPeer::RECIPIENT_ID."=".CompanyPeer::ID." 
                LEFT JOIN ".CompanyUserPeer::TABLE_NAME." ON ".CompanyPeer::ID."=".CompanyUserPeer::COMPANY_ID." 
                WHERE ".MessageRecipientPeer::IS_READ."=0 AND 
                      ((".MessageRecipientPeer::RECIPIENT_TYPE_ID."=".PrivacyNodeTypePeer::PR_NTYP_USER." AND  
                          ".MessageRecipientPeer::RECIPIENT_ID."=".$this->getId()." 
".($include_involved && $ids!==null?") OR 
                       (".MessageRecipientPeer::RECIPIENT_TYPE_ID."=".PrivacyNodeTypePeer::PR_NTYP_COMPANY." AND
                          ".MessageRecipientPeer::RECIPIENT_ID." IN $ids AND 
                          ".CompanyUserPeer::OBJECT_ID."={$this->getId()} AND CompanyUserPeer::OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER:"")." 
                       )) AND 
                      ".MessageRecipientPeer::FOLDER_ID."=".MessagePeer::MFOLDER_INBOX." AND 
                      (".MessageRecipientPeer::DELETED_AT." IS NULL)";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $rs = $stmt->fetch(PDO::FETCH_NUM);
        return $rs[0];
    }
    
    public function hasUsername()
    {
        return $this->getLogin()->hasUsername();  
    }

    public function getUsername()
    {
        return $this->getLogin()->getUsername();  
    }

    public function getProfileUrl()
    {
        return (sfContext::getInstance()->getConfiguration()->getApplication() == "cm" ? "@" : "@cm.") . "user-profile?hash={$this->getHash()}";
    }
    
    public function getProfileActionUrl($action)
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "cm")
            return $this->hasUsername()?"@user-profile-action?hash={$this->getHash()}&action=$action":"@user-profile-action?hash={$this->getHash()}&action=$action";
        else
            return $this->hasUsername()?"@cm.user-profile-action?hash={$this->getHash()}&action=$action":"@cm.user-profile-action?hash={$this->getHash()}&action=$action";
    }
    
    public function getPhotosUrl($paramstr = null)
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "cm")
            return ($this->hasUsername()?"@user-profile-action?hash={$this->getHash()}&action=photos":"@user-profile-action?hash={$this->getHash()}&action=photos") . (isset($paramstr) ? "&$paramstr" : "");
        else
            return ($this->hasUsername()?"@cm.user-profile-action?hash={$this->getHash()}&action=photos":"@cm.user-profile-action?hash={$this->getHash()}&action=photos") . (isset($paramstr) ? "&$paramstr" : "");
    }
    
    public function getUploadUrl()
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "cm")
            return $this->hasUsername()?"@user-upload-photo?username=".$this->getLogin()->getUsername():"@profile-upload-photo?id=".$this->getId();
        else
            return $this->hasUsername()?"@cm.user-upload-photo?username=".$this->getLogin()->getUsername():"@cm.profile-upload-photo?id=".$this->getId();
    }
    
    public function isFriendsWith($user_id)
    {
        if ($user_id instanceof User) $user_id = $user_id->getId();

        $con = Propel::getConnection();
        $sql = "SELECT * FROM EMT_RELATION_VIEW
                WHERE (USER_ID=".($this->getId() ? $this->getId() : 0)." AND RELATED_USER_ID=$user_id) OR (USER_ID=$user_id AND RELATED_USER_ID=".($this->getId() ? $this->getId() : 0).")
                AND STATUS=".RelationPeer::RL_STAT_ACTIVE;

        $stmt = $con->prepare($sql);
        $stmt->execute();
        $rr = RelationPeer::populateObjects($stmt);
        return count($rr) ? $rr[0] : null;
    }
    
    public function hasRelation($user_id)
    {
        if ($user_id instanceof User) $user_id = $user_id->getId();

        $filter = array(RelationPeer::RL_STAT_ENDED_BY_STARTER_USER,
                        RelationPeer::RL_STAT_ENDED_BY_TARGET_USER,
                        RelationPeer::RL_STAT_REJECTED);
        
        $con = Propel::getConnection();
        $sql = "SELECT * FROM EMT_RELATION_VIEW
                WHERE ((USER_ID=".($this->getId() ? $this->getId() : 0)." AND RELATED_USER_ID=$user_id) OR (USER_ID=$user_id AND RELATED_USER_ID=".($this->getId() ? $this->getId() : 0)."))
                AND STATUS NOT IN (" . implode(',',$filter) . ")
                ";

        $stmt = $con->prepare($sql);
        $stmt->execute();
        $rr = RelationPeer::populateObjects($stmt);
        return count($rr) ? $rr[0] : null;
    }
    
    public function getRelation($user_id)
    {
        $con = Propel::getConnection();
        $sql = "SELECT * FROM
                (
                    SELECT EMT_RELATION.*,
                    RANK() OVER (PARTITION BY RELATED_USER_ID, USER_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                    FROM EMT_RELATION
                )   
                WHERE SEQNUMBER=1 AND (USER_ID={$this->getId()} AND RELATED_USER_ID=$user_id) OR (USER_ID=$user_id AND RELATED_USER_ID={$this->getId()})
               ";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $rr = RelationPeer::populateObjects($stmt);
        return count($rr) ? $rr[0] : null;
    }
    
    public function getRelationWith($subj_user_id)
    {
        $c = new Criteria();
        $c1 = $c->getNewCriterion(RelationPeer::USER_ID, $subj_user_id);
        $c2 = $c->getNewCriterion(RelationPeer::RELATED_USER_ID, $subj_user_id);
        $c1->addOr($c2);
        $c->add($c1);
        $c->setLimit(1);
        $c->addDescendingOrderByColumn(RelationPeer::CREATED_AT);
        $rel = $this->getRelationList($c);
        if (count($rel))
        {
            return $rel[0];
        }
        else
        {
            return null;
        }
    }
    
    public function getProfilePicture()
    {
        $profile = $this->getUserProfile();
        if ($profile)
            return $profile->getMediaItem();
        else
            return null;
    }
    
    public function getProfilePictureUri($size = MediaItemPeer::LOGO_TYP_SMALL)
    {
        $ppic = $this->getProfilePicture();
        $parray = array(MediaItemPeer::LOGO_TYP_SMALL     => "content/user/profile/S",
                      MediaItemPeer::LOGO_TYPE_MEDIUM   => "content/user/profile/M",
                      MediaItemPeer::LOGO_TYPE_LARGE    => "content/user/profile"
                );
        $path = $parray[$size];
        $gender = $this->getGender()===UserProfilePeer::GENDER_FEMALE ? 'female' : 'male';
        if ($ppic)
        {
            switch ($size)
            {
                case MediaItemPeer::LOGO_TYPE_MEDIUM :
                    return file_exists($ppic->getMediumPath()) ? $ppic->getMediumUri() : "$path/no_photo_{$gender}_not_found.jpg";
                    break;
                case MediaItemPeer::LOGO_TYPE_LARGE :
                    return file_exists($ppic->getPath()) ? $ppic->getUri() : "$path/no_photo_{$gender}_not_found.jpg";
                    break;
                case MediaItemPeer::LOGO_TYP_SMALL :
                default: 
                    return file_exists($ppic->getThumbnailPath()) ? $ppic->getThumbnailUri() : "$path/no_photo_{$gender}_not_found.jpg";
                    break;
            }
        }
        else
        {
            return "$path/no_photo_{$gender}.jpg";
        }
    }
    
    public function setProfilePictureId($mi_id)
    {
        $profile = $this->getUserProfile();
        $item = PrivacyNodeTypePeer::retrieveObject($mi_id, PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM);
        
        if ($item)
        {
            if (!$profile)
            {
                $profile = new UserProfile();
                $profile->setPhotoId($mi_id);
                $profile->save();
                $this->setProfileId($profile->getId());
                $this->save();
            }
            else
            {
                if ($profile->getPhotoId() != $mi_id)
                {
                    $profile->setPhotoId($mi_id);
                    $profile->save();
                }
            }
            
            //ActionLogPeer::Log($this, ActionPeer::ACT_UPLOAD_PROFILE_PICTURE, null, $item);
            return true;
        }
        return false;
    }
    
    public function getProfilePictureId()
    {
        $profile = $this->getUserProfile();
        if ($profile)
        {
            return $profile->getPhotoId();
        }
        return null;
    }
    
    public function setupRelationWith($user_id, $status = RelationPeer::RL_STAT_PENDING_CONFIRMATION, $role_id = null)
    {
        if ($this->isFriendsWith($user_id)) return false;
        $relation = new Relation();
        $relation->setStatus($status);
        $relation->setUserId($this->getId());
        $relation->setRelatedUserId($user_id);
        $relation->setRoleId($role_id ? $role_id : RolePeer::RL_CANDIDATE_NETWORK_MEMBER);
        $relation->save();
        return $relation;
    }
    
    public function getRequests()
    {
        $c = new Criteria();
        $c->add(RelationPeer::STATUS, RelationPeer::RL_STAT_PENDING_CONFIRMATION);
        return $this->getRelationsRelatedByRelatedUserId($c);
    }
    
    public function getRequestCount()
    {
        return $this->getFriendshipRequests(true) + $this->getGroupInvitations(true) + $this->getGroupRequests(true) + $this->getRelationUpdateRequests(true);;
    }
    
    public function getNotificationCount()
    {
        return 0;
    }
    
    public function getGroupRequests($count = false,  $group_id = null)
    {
        $con = Propel::getConnection();
        $sql = "SELECT ".($count ? "COUNT(*)" : "MEMBER.*")." FROM 
                (
                    SELECT * FROM
                    (
                        SELECT EMT_GROUP_MEMBERSHIP.*,
                        RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                        FROM EMT_GROUP_MEMBERSHIP
                    )
                    WHERE SEQNUMBER=1
                ) MEMBER,
                EMT_GROUP, 
                (
                    SELECT * FROM
                    (
                        SELECT DISTINCT EMT_GROUP_MEMBERSHIP.GROUP_ID,
                        RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                        FROM EMT_GROUP_MEMBERSHIP
                        WHERE OBJECT_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND STATUS=".GroupMembershipPeer::STYP_ACTIVE." AND (ROLE_ID=".RolePeer::RL_GP_OWNER." OR ROLE_ID=".RolePeer::RL_GP_MODERATOR.")
                    )
                    WHERE SEQNUMBER=1  
                ) MYGROUP
                WHERE MEMBER.GROUP_ID=EMT_GROUP.ID AND EMT_GROUP.ID=MYGROUP.GROUP_ID AND MEMBER.STATUS=".GroupMembershipPeer::STYP_PENDING." AND EMT_GROUP.BLOCKED=0
                ".(isset($group_id) && !is_null($group_id) ?"AND MEMBER.GROUP_ID=$group_id":"")."
                ORDER  BY MEMBER.CREATED_AT DESC
                ";
                
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $count ? (int)$stmt->fetch(PDO::FETCH_COLUMN, 0) : GroupMembershipPeer::populateObjects($stmt);
    }
    
    public function getFriendshipRequests($count = false)
    {
        $con = Propel::getConnection();
        $sql = "SELECT ".($count ? "COUNT(*)" : "RELATION.*")." FROM 
                (
                    SELECT * FROM
                    (
                        SELECT EMT_RELATION.*,
                        RANK() OVER (PARTITION BY RELATED_USER_ID, USER_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                        FROM EMT_RELATION
                        WHERE RELATED_USER_ID={$this->getId()} OR USER_ID={$this->getId()}
                    )
                    WHERE SEQNUMBER=1 
                ) RELATION,
                EMT_USER
                WHERE RELATION.USER_ID=EMT_USER.ID AND RELATION.RELATED_USER_ID={$this->getId()} AND RELATION.STATUS=".RelationPeer::RL_STAT_PENDING_CONFIRMATION."
                ORDER  BY RELATION.CREATED_AT DESC
                ";
                
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $count ? (int)$stmt->fetch(PDO::FETCH_COLUMN, 0) : RelationPeer::populateObjects($stmt);
    }

    public function getRelationUpdateRequests($count = false)
    {
        $con = Propel::getConnection();
        $sql = "SELECT ".($count ? "COUNT(*)" : "RELATION_UPDATE.*")." FROM 
                (
                    SELECT EMT_RELATION.*,
                    RANK() OVER (PARTITION BY RELATED_USER_ID, USER_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                    FROM EMT_RELATION
                ) RELATION,
                EMT_USER, 
                (
                    SELECT EMT_RELATION_UPDATE.*,
                    RANK() OVER (PARTITION BY SUBJECT_TYPE_ID, SUBJECT_ID, OBJECT_TYPE_ID, OBJECT_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                    FROM EMT_RELATION_UPDATE
                    WHERE OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND SUBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER."
                ) RELATION_UPDATE
                WHERE RELATION.SEQNUMBER=1 AND RELATION_UPDATE.SEQNUMBER=1
                    AND 
                        ((RELATION.USER_ID=RELATION_UPDATE.SUBJECT_ID AND RELATION.RELATED_USER_ID=RELATION_UPDATE.OBJECT_ID) OR
                         (RELATION.USER_ID=RELATION_UPDATE.OBJECT_ID AND RELATION.RELATED_USER_ID=RELATION_UPDATE.SUBJECT_ID)
                        )
                    AND RELATION_UPDATE.SUBJECT_ID=EMT_USER.ID AND RELATION_UPDATE.STATUS=".RelationUpdatePeer::RU_STATUS_PENDING." AND RELATION.STATUS=".RelationPeer::RL_STAT_ACTIVE."
                    AND RELATION_UPDATE.OBJECT_ID={$this->getId()}
                ORDER  BY RELATION_UPDATE.CREATED_AT DESC
                ";
                
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $count ? (int)$stmt->fetch(PDO::FETCH_COLUMN, 0) : RelationUpdatePeer::populateObjects($stmt);
    }
    
    public function getGroupInvitations($count = false, $group_id = null, $retrieve_array = false)
    {
        $con = Propel::getConnection();
        $sql = "SELECT ".($count ? "COUNT(*)" : ($retrieve_array ? "EMT_GROUP.*" : "MEMBER.*"))." FROM 
                (
                    SELECT * FROM
                    (
                        SELECT EMT_GROUP_MEMBERSHIP.*,
                        RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                        FROM EMT_GROUP_MEMBERSHIP
                    )
                    WHERE SEQNUMBER=1
                ) MEMBER,
                EMT_GROUP 
                WHERE MEMBER.GROUP_ID=EMT_GROUP.ID AND MEMBER.OBJECT_ID={$this->getId()} AND MEMBER.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND MEMBER.STATUS=".GroupMembershipPeer::STYP_INVITED." AND EMT_GROUP.BLOCKED=0
                AND EMT_GROUP.ID NOT IN 
                (
                    SELECT GROUP_ID FROM
                    (
                        SELECT DISTINCT EMT_GROUP_MEMBERSHIP.GROUP_ID,
                        RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                        FROM EMT_GROUP_MEMBERSHIP
                        WHERE OBJECT_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND (STATUS=".GroupMembershipPeer::STYP_ACTIVE." OR ROLE_ID=".RolePeer::RL_GP_OWNER.")
                    )
                    WHERE SEQNUMBER=1  
                )
                ".(isset($group_id) && !is_null($group_id) ? "AND MEMBER.GROUP_ID=$group_id" : "")."
                ORDER  BY MEMBER.CREATED_AT DESC
                ";
                
        $stmt = $con->prepare($sql);
        $stmt->execute();
        if (!$count && $retrieve_array)
        {
            $groups = GroupPeer::populateObjects($stmt);
            foreach ($groups as $key => $group)
            {
                $groups[$key][0] = $this->getGroupInvitations(false, $group->getId());
            }
        }
        return $count ? (int)$stmt->fetch(PDO::FETCH_COLUMN, 0) : ($retrieve_array ? $groups : GroupMembershipPeer::populateObjects($stmt));
    }
    
    public function getRelationList(Criteria $criteria=NULL)
    {
        if ($criteria)
            $c = clone $criteria;
        else
            $c = new Criteria();

        $c1 = $c->getNewCriterion(RelationPeer::RELATED_COMPANY_ID, NULL, Criteria::ISNULL);
        $c1->addAnd($c->getNewCriterion(RelationPeer::RELATED_USER_ID, NULL, Criteria::ISNOTNULL));
        $c1->addAnd($c->getNewCriterion(RelationPeer::USER_ID, $this->getId()));
        
        $c2 = $c->getNewCriterion(RelationPeer::RELATED_COMPANY_ID, NULL, Criteria::ISNULL);
        $c2->addAnd($c->getNewCriterion(RelationPeer::RELATED_USER_ID, $this->getId()));
        $c2->addAnd($c->getNewCriterion(RelationPeer::USER_ID, NULL, Criteria::ISNOTNULL));

        $c1->addOr($c2);
        $c1->addAnd($c->getNewCriterion(RelationPeer::STATUS, RelationPeer::RL_STAT_ACTIVE));
        $c->add($c1);
        return RelationPeer::doSelect($c);
    }
    
    public function countFriends()
    {
        return $this->getFriends(null, false, true);
    }

    public function getFriends($keyword = NULL, $rand=false, $count = false, $page = null, $ipp = null, $return_pager = false)
    {
        if ($return_pager)
        {
            $rand = false;
            $count = false;
        }

        $user_id = $this->getId() ? $this->getId() : 0;
        $relation_active = RelationPeer::RL_STAT_ACTIVE;
        $con = Propel::getConnection();
        $sql = "SELECT " . ($count ? "COUNT(EUSR.*)" : "EUSR.*") . " FROM
                ( 
                    SELECT EMT_USER.* FROM EMT_RELATION_VIEW
                    LEFT JOIN EMT_USER ON EMT_RELATION_VIEW.RELATED_USER_ID=EMT_USER.ID
                    WHERE EMT_RELATION_VIEW.USER_ID=$user_id AND EMT_RELATION_VIEW.STATUS=$relation_active
                    UNION ALL
                    SELECT EMT_USER.* FROM EMT_RELATION_VIEW
                    LEFT JOIN EMT_USER ON EMT_RELATION_VIEW.USER_ID=EMT_USER.ID
                    WHERE EMT_RELATION_VIEW.RELATED_USER_ID=$user_id AND EMT_RELATION_VIEW.STATUS=$relation_active
                ) EUSR
                WHERE NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE EMT_BLOCKLIST.LOGIN_ID=EUSR.LOGIN_ID AND EMT_BLOCKLIST.ACTIVE=1)"
                .($keyword?" AND NLSUPPER(DISPLAY_NAME || ' ' || DISPLAY_LASTNAME, 'NLS_SORT=GENERIC_M_CI') LIKE NLSUPPER('%$keyword%', 'NLS_SORT=GENERIC_M_CI')":"")
                .(!$count ? "ORDER BY ".($rand ? "dbms_random.value" : "NLSSORT(DISPLAY_NAME,'NLS_SORT=GENERIC_M_CI'), NLSSORT(DISPLAY_LASTNAME,'NLS_SORT=GENERIC_M_CI')") : "");

        $sql = !$return_pager && $ipp ? "SELECT * FROM ($sql) WHERE ROWNUM < $ipp" : $sql;
        
        if ($return_pager)
        {
            $pager = new EmtPager('User', $ipp);
            $pager->setSql($sql);
            $pager->setPage($page);
            $pager->init();
            return $pager;
        }
        else
        {
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return $count ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : UserPeer::populateObjects($stmt);
        }
    }
    
    public function getFriendsMemberOf($groupid, $num = null, $rand=false, $keyword = NULL)
    {
        $con = Propel::getConnection();
        $sql = "SELECT * FROM
                (
                    SELECT * FROM (SELECT EMT_USER.* FROM EMT_USER, EMT_RELATION
                    WHERE (EMT_RELATION.RELATED_USER_ID=EMT_USER.ID AND EMT_RELATION.USER_ID={$this->getId()} AND EMT_RELATION.STATUS=".RelationPeer::RL_STAT_ACTIVE. " " . ($keyword?" AND NLS_LOWER(EMT_USER.NAME || ' ' || EMT_USER.LASTNAME) LIKE NLS_LOWER('%$keyword%')":"")." )
                    UNION
                    SELECT EMT_USER.* FROM EMT_USER, EMT_RELATION
                    WHERE (EMT_RELATION.USER_ID=EMT_USER.ID AND EMT_RELATION.RELATED_USER_ID={$this->getId()} AND EMT_RELATION.STATUS=".RelationPeer::RL_STAT_ACTIVE. " " . ($keyword?" AND NLS_LOWER(EMT_USER.NAME || ' ' || EMT_USER.LASTNAME) LIKE NLS_LOWER('%$keyword%')":"")." ))
                    ORDER BY ".($rand ? "dbms_random.value" : "NLSSORT(NAME,'NLS_SORT=GENERIC_M_CI'), NLSSORT(LASTNAME,'NLS_SORT=GENERIC_M_CI')") ."
                )
                WHERE ID IN 
                (
                    SELECT OBJECT_ID FROM EMT_GROUP_MEMBERSHIP
                    WHERE GROUP_ID=$groupid AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND STATUS=".GroupMembershipPeer::STYP_ACTIVE."
                )
                ";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return UserPeer::populateObjects($stmt);
    }
    
    public function can($action_id, $object=null, $object_type_id = null)
    {
        if (isset($object) && is_object($object))
        {
            $object_id = $object->getId();
            $object_type_id = $object->getObjectTypeId();
        }
        else
        {
            $object_id = $object;
            if (!$object_type_id) return null;
        }
        
        $con = Propel::getConnection();
$sql = "

SELECT * FROM
(
    SELECT * FROM
    (
        SELECT FS.*, SROLES.ID SUB_VROLE_ID, SROLES.LVL SUB_VROLE_LVL, OROLES.ID OBJ_VROLE_ID, OROLES.LVL OBJ_VROLE_LVL FROM 
        EMT_CONNECTIONS FS
        LEFT JOIN
        (
            SELECT CONNECT_BY_ROOT ID SPOINT, ID, SYSNAME, LEVEL LVL FROM EMT_ROLE
            START WITH PARENT_ID IS NOT NULL
            CONNECT BY NOCYCLE PRIOR PARENT_ID = ID
        ) OROLES ON FS.P_ROLE_ON_OBJECT=OROLES.SPOINT
        LEFT JOIN
        (
            SELECT CONNECT_BY_ROOT ID SPOINT, ID, SYSNAME, LEVEL LVL FROM EMT_ROLE
            START WITH PARENT_ID IS NOT NULL
            CONNECT BY NOCYCLE PRIOR PARENT_ID = ID
        ) SROLES ON FS.P_ROLE_ON_SUBJECT=SROLES.SPOINT
    ) ASSIG, 
    (
        SELECT EMT_PRIVACY_PREFERENCE.*, 
            CASE
            WHEN (COALESCE(SUBJECT_ID, 0) * COALESCE(OBJECT_ID, 0) > 0) THEN 1
            WHEN COALESCE(OBJECT_ID, 0) < COALESCE(SUBJECT_ID, 0) THEN 2
            WHEN COALESCE(OBJECT_ID, 0) > COALESCE(SUBJECT_ID, 0) THEN 3
            ELSE 4
            END OBJECTED 
        FROM EMT_PRIVACY_PREFERENCE
    ) PP
    
    WHERE 
        ((ROOT_ID=".($this->getId() ? $this->getId() : 0)." AND ROOT_TYPE_ID=1) OR (ROOT_ID IS NULL))
        AND 
        (P_SUBJECT_TYPE_ID=SUBJECT_TYPE_ID AND (P_SUBJECT_ID=SUBJECT_ID OR SUBJECT_ID IS NULL))
        AND
        (P_OBJECT_TYPE_ID=OBJECT_TYPE_ID AND (P_OBJECT_ID=OBJECT_ID OR OBJECT_ID IS NULL))
        AND
        (SUB_VROLE_ID=ROLE_ON_SUBJECT OR ROLE_ON_SUBJECT IS NULL)
        AND
        (OBJ_VROLE_ID=ROLE_ON_OBJECT OR ROLE_ON_OBJECT IS NULL)
        AND
        (P_OBJECT_TYPE_ID=$object_type_id AND P_OBJECT_ID=$object_id)
        AND
        (ACTION_ID=$action_id)
)
ORDER BY OBJ_VROLE_LVL DESC NULLS LAST, SUB_VROLE_LVL DESC NULLS LAST, OBJECTED, P_SUBJECT_ID
";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (is_array($row) && array_key_exists('ALLOWED', $row))
        {
            return $row['ALLOWED'];
        }
        else
        {
            return false;
        }
    }
    
    public function getPrivacyPreferences($action_id = NULL)
    {
        return PrivacyPreferencePeer::retrieveByObject($this->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, $action_id);
    }
    
    public function getPrivacyPrefMatrix($actions = null)
    {
        $prefs = PrivacyPreferencePeer::retrieveByObject($this->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, $actions, true);
        $mtr = array();
        $x = array();

        foreach ($prefs as $pref)
        {
            if (!isset($x[$pref->getActionId()])) $x[$pref->getActionId()] = array(0);
            $mtr[$pref->getActionId()][$pref->getRoleOnObject()]['VAL'] = $pref->getAllowed();
            $mtr[$pref->getActionId()][$pref->getRoleOnObject()]['ID'] = $pref->getObjectId() ? $pref->getId() : null;
            if (isset($mtr[$pref->getActionId()][RolePeer::RL_NETWORK_MEMBER]) && $mtr[$pref->getActionId()][RolePeer::RL_NETWORK_MEMBER]['VAL'] == 1) array_push($x[$pref->getActionId()], RolePeer::RL_NETWORK_MEMBER);
            else if (isset($mtr[$pref->getActionId()][RolePeer::RL_NETWORK_MEMBER]) && $mtr[$pref->getActionId()][RolePeer::RL_NETWORK_MEMBER]['VAL'] == 0) $x[$pref->getActionId()] = array_diff($x[$pref->getActionId()], array(RolePeer::RL_NETWORK_MEMBER));
            if (isset($mtr[$pref->getActionId()][RolePeer::RL_ALL]) && $mtr[$pref->getActionId()][RolePeer::RL_ALL]['VAL'] == 1) array_push($x[$pref->getActionId()], RolePeer::RL_ALL);
            else if (isset($mtr[$pref->getActionId()][RolePeer::RL_ALL]) && $mtr[$pref->getActionId()][RolePeer::RL_ALL]['VAL'] == 0) $x[$pref->getActionId()] = array_diff($x[$pref->getActionId()], array(RolePeer::RL_ALL));
        }
        foreach ($mtr as $act => $mt)
        {
            $mtr[$act]['X'] = array_pop($x[$act]);
        }
        return $mtr;
    }
    
    public function getPrivacyPref($pref_id, $init_new = true, $action_id = null, $role_id = null)
    {
        if ($pref_id)
        {
            $c = new Criteria();
            $c->add(PrivacyPreferencePeer::ID, $pref_id);
            $c->add(PrivacyPreferencePeer::OBJECT_ID, $this->getId());
            $pref = PrivacyPreferencePeer::doSelectOne($c);
        }
        else
        {
            $pref = null;
        }
        if (!$pref && $init_new)
        {
            if (isset($action_id) && isset($role_id))
            {
                $pref = new PrivacyPreference();
                $pref->setObjectId($this->getId());
                $pref->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                $pref->setActionId($action_id);
                $pref->setRoleOnObject($role_id);
                return $pref;
            }
            else
            {
                throw new Exception('action_id and role_id parameters should be provided in order to initialize new privacy preference');
            }
        }
        else
        {
            return $pref;
        }
    }
    public function getMediaItems($mi_type_id, $mi_id, $rand, $count, $page, $ipp, $return_pager)
    {
        return MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, $mi_type_id, $mi_id, $rand, $count, $page, $ipp, $return_pager);
    }

    public function getPhoto($mi_id)
    {
        $item = MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, MediaItemPeer::MI_TYP_ALBUM_PHOTO, $mi_id);
        if (count($item))
            return $item[0];
        else
            return null;
    }
    
    public function getPhotos(Criteria $c1 = null, $count = false)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_ALBUM_PHOTO);
        return $count ? MediaItemPeer::doCount($c) : MediaItemPeer::doSelect($c);
    }
    
    public function getSentMessages()
    {
        if (is_null($this->aSentMessages))
        {
            $c = new Criteria();
            $c->add(MessagePeer::SENDER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
            $c->add(MessagePeer::SENDER_ID, $this->id);
            $c->add(MessagePeer::DELETED_AT, null, Criteria::ISNULL);
            $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
            $this->aSentMessages = MessagePeer::doSelect($c);
        }
        return $this->aSentMessages;
    }
    
    public function getMessages()
    {
        if (is_null($this->aReceivedMessages))
        {
            $c = new Criteria();
            $c->addJoin(MessagePeer::ID, MessageRecipientPeer::MESSAGE_ID, Criteria::LEFT_JOIN);
            $c->add(MessageRecipientPeer::RECIPIENT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
            $c->add(MessageRecipientPeer::RECIPIENT_ID, $this->id);
            $c->add(MessageRecipientPeer::FOLDER_ID, MessagePeer::MFOLDER_INBOX);
            $c->add(MessageRecipientPeer::DELETED_AT, null, Criteria::ISNULL);
            $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
            $this->aReceivedMessages = MessagePeer::doSelect($c);
        }
        return $this->aReceivedMessages;
    }
    
    public function getArchivedMessages()
    {
        if (is_null($this->aArchivedMessages))
        {
            $c = new Criteria();
            $c->addJoin(MessagePeer::ID, MessageRecipientPeer::MESSAGE_ID, Criteria::LEFT_JOIN);
            $c->add(MessageRecipientPeer::RECIPIENT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
            $c->add(MessageRecipientPeer::RECIPIENT_ID, $this->id);
            $c->add(MessageRecipientPeer::FOLDER_ID, MessagePeer::MFOLDER_ARCHIVED);
            $c->add(MessageRecipientPeer::DELETED_AT, null, Criteria::ISNULL);
            $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
            $this->aReceivedMessages = MessagePeer::doSelect($c);
        }
        return $this->aReceivedMessages;
    }
    
    public function getWorkHistory($asc_order = true)
    {
        $con = Propel::getConnection();
        $sql = "SELECT ".ResumeWorkPeer::TABLE_NAME.".*  FROM ".UserPeer::TABLE_NAME."
                INNER JOIN ".ResumePeer::TABLE_NAME." ON ".ResumePeer::USER_ID."=".UserPeer::ID."
                INNER JOIN ".ResumeWorkPeer::TABLE_NAME." ON ".ResumeWorkPeer::RESUME_ID."=".ResumePeer::ID."
                WHERE ".UserPeer::ID."=".$this->id."
                ORDER BY ".ResumeWorkPeer::PRESENT." ASC,".ResumeWorkPeer::DATE_FROM." DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return ResumeWorkPeer::populateObjects($stmt);
    }
    
    public function getEducationHistory($asc_order = true)
    {
        $con = Propel::getConnection();
        $sql = "SELECT ".ResumeSchoolPeer::TABLE_NAME.".*  FROM ".UserPeer::TABLE_NAME."
                INNER JOIN ".ResumePeer::TABLE_NAME." ON ".ResumePeer::USER_ID."=".UserPeer::ID."
                INNER JOIN ".ResumeSchoolPeer::TABLE_NAME." ON ".ResumeSchoolPeer::RESUME_ID."=".ResumePeer::ID."
                WHERE ".UserPeer::ID."=".$this->id."
                ORDER BY ".ResumeSchoolPeer::PRESENT." ASC,".ResumeSchoolPeer::DATE_FROM." DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return ResumeSchoolPeer::populateObjects($stmt);
    }
    
    public function createFolder($name, $type)
    {
        try
        {
            $f = new MediaItemFolder();
            $f->setName($name);
            $f->setOwnerId($this->id);
            $f->setOwnerTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
            $f->setTypeId($type);
            $f->save();
        }
        catch (Exception $e)
        {
            return null;
        }
        return $f;
    }
    
    public function createAlbum($name)
    {
        return $this->createFolder($name, MediaItemPeer::MI_TYP_ALBUM_PHOTO);
    }
    
    public function getFolders($type=null)
    {
        $c = new Criteria();
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(MediaItemFolderPeer::OWNER_ID, $this->id);
        if (isset($type)) $c->add(MediaItemFolderPeer::TYPE_ID, $type);
        return MediaItemFolderPeer::doSelect($c);
    }
    
    public function getFolder($id, $type=null)
    {
        $c = new Criteria();
        $c->add(MediaItemFolderPeer::ID, $id);
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(MediaItemFolderPeer::OWNER_ID, $this->id);
        if (isset($type)) $c->add(MediaItemFolderPeer::TYPE_ID, $type);
        return MediaItemFolderPeer::doSelectOne($c);
    }
    
    public function getFolderByName($name, $type=null)
    {
        $c = new Criteria();
        $c->add(MediaItemFolderPeer::NAME, $name);
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(MediaItemFolderPeer::OWNER_ID, $this->id);
        if (isset($type)) $c->add(MediaItemFolderPeer::TYPE_ID, $type);
        return MediaItemFolderPeer::doSelectOne($c);
    }
    
    public function getFolderByType($type)
    {
        $c = new Criteria();
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(MediaItemFolderPeer::OWNER_ID, $this->id);
        $c->add(MediaItemFolderPeer::TYPE_ID, $type);
        return MediaItemFolderPeer::doSelectOne($c);
    }
    
    public function getAlbums()
    {
        return $this->getFolders(MediaItemPeer::MI_TYP_ALBUM_PHOTO);
    }
    
    public function getAlbum($id)
    {
        return $this->getFolder($id, MediaItemPeer::MI_TYP_ALBUM_PHOTO);
    }
    
    public function getAlbumByName($name)
    {
        return $this->getFolderByName($name, MediaItemPeer::MI_TYP_ALBUM_PHOTO);
    }
    
    public function getCompany($id, $role_id = 8)
    {
        $c = new Criteria();
        $c->addJoin(UserPeer::ID, CompanyUserPeer::OBJECT_ID, Criteria::INNER_JOIN);
        $c->addJoin(CompanyUserPeer::COMPANY_ID, CompanyPeer::ID, Criteria::INNER_JOIN);
        $c->add(UserPeer::ID, $this->getId());
        $c->add(CompanyUserPeer::COMPANY_ID, $id);
        $c->add(CompanyUserPeer::ROLE_ID, RolePeer::RL_CM_OWNER);
        $c->add(CompanyUserPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(CompanyUserPeer::STATUS, CompanyUserPeer::CU_STAT_ACTIVE);
        return CompanyPeer::doSelectOne($c);
    }
    
    public function getCompanyLogins($c = null)
    {
        return $this->getLogin()->getCompanyLogins($c);
    }
    
    public function getCompanyRelations()
    {
        $c = new Criteria();
        $c->addJoin(UserPeer::ID, CompanyUserPeer::OBJECT_ID, Criteria::INNER_JOIN);
        $c->addJoin(CompanyUserPeer::COMPANY_ID, CompanyPeer::ID, Criteria::INNER_JOIN);
        $c->add(UserPeer::ID, $this->getId());
        $c->add(CompanyUserPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        return CompanyUserPeer::doSelect($c);
    }
    
    public function getLastLoginDate($format='U')
    {
        $logins = ActionLogPeer::getActionLogs($this, ActionPeer::ACT_LOG_IN, null, null, false);
        return count($logins)>1?$logins[1]->getCreatedAt($format):null;
    }
    
    public function getPublication($item_id=null, $item_type_id=null, $order_asc = false)
    {
        $author = $this->getAuthor();
        if (!$author) return null;
        $c = new Criteria();
        $c->add(PublicationPeer::ID, $item_id);
        $c->add(PublicationPeer::TYPE_ID, $item_type_id);
        $c->add(PublicationPeer::AUTHOR_ID, $author->getId());
        if ($order_asc) $c->addAscendingOrderByColumn(PublicationPeer::CREATED_AT);
        else $c->addDescendingOrderByColumn(PublicationPeer::CREATED_AT);
        
        $pubs = PublicationPeer::doSelect($c);
        return count($pubs)==1?$pubs[0]:$pubs;
    }
    
    public function getAuthor()
    {
        $c = new Criteria();
        $c->setLimit(1);
        $authors = $this->getAuthors($c);
        return count($authors)?$authors[0]:null;
    }

    public function getSuggestedFriendsPager($level = null, $random = true, $ipp = 20, $page = null, $return_pager = false)
    {
        $level_limit = $level ? $level : 3;
        $subject_id = $this->isNew() ? 0 : $this->getId();

        // ignoring random option if using paging for the query
        if (isset($page)) $random = false;
        
        $con = Propel::getConnection();

        $sql = "
            select distinct pr1.*, 0 from (
                select distinct emt_user.*, lvl from (
                    select emt_relation.*, LEVEL lvl from emt_relation
                    where status=2
                    start with emt_relation.user_id=$subject_id
                    connect by nocycle prior emt_relation.related_user_id=emt_relation.user_id and LEVEL<({$level_limit}+1)
                ) relation
                left join emt_user on relation.related_user_id=emt_user.id
                ".($level ? "where lvl = $level" : '')."
                
                UNION ALL
                
                select distinct emt_user.*, lvl from (
                    select emt_relation.*, LEVEL lvl from emt_relation
                    where status=2
                    start with emt_relation.related_user_id=$subject_id
                    connect by nocycle prior emt_relation.user_id=emt_relation.related_user_id and LEVEL<({$level_limit}+1)
                ) relation
                left join emt_user on relation.user_id=emt_user.id
                ".($level ? "where lvl = $level" : '')."
            ) pr1
            where not exists (
                select 1 from emt_relation rel where ((rel.user_id=$subject_id and rel.related_user_id=pr1.id) or (rel.user_id=pr1.id and rel.related_user_id=$subject_id)) and (status=2 or status=1)
            ) and not exists (
                select 1 from emt_ignore_advise adv where (adv.user_id=$subject_id and adv.related_user_id=pr1.id)
            ) and not exists (
                select 1 from emt_blocklist where emt_blocklist.login_id=pr1.login_id and emt_blocklist.active=1
            ) and id!=$subject_id
            ". ($random ? "order by dbms_random.value" : "");
        
        $pager = new EmtPager('User', $ipp);
        $pager->setSql($sql);
        $pager->setPage($page);
        $pager->setBindColumns(array('relevel' => UserPeer::NUM_COLUMNS + 1));
        $pager->init();
        return $return_pager ? $pager : $pager->getResults();
    }
    
    public function countFriendsToAdvise($level = 1)
    {
        $con = Propel::getConnection();
        $sql = "
select count(*) from (
    select distinct * from (
        select distinct emt_user.*, lvl from (
            select emt_relation.*, LEVEL lvl from emt_relation
            where status=2
            start with emt_relation.user_id={$this->getId()}
            connect by nocycle prior emt_relation.related_user_id=emt_relation.user_id and LEVEL<({$level}+1)
        ) relation
        left join emt_user on relation.related_user_id=emt_user.id
        where lvl = $level 
        
        UNION ALL
        
        select distinct emt_user.*, lvl from (
            select emt_relation.*, LEVEL lvl from emt_relation
            where status=2
            start with emt_relation.related_user_id={$this->getId()}
            connect by nocycle prior emt_relation.user_id=emt_relation.related_user_id and LEVEL<({$level}+1)
        ) relation
        left join emt_user on relation.user_id=emt_user.id
        where lvl = $level 
    ) pr1
    where not exists (
        select * from emt_relation rel where (rel.user_id={$this->getId()} and rel.related_user_id=pr1.id) or (rel.user_id=pr1.id and rel.related_user_id={$this->getId()})
    ) and id!={$this->getId()}
)";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN, 0);
    }
    
    public function getConsentLogin($service_id)
    {
        $c = new Criteria();
        $c->add(ConsentLoginPeer::SERVICE_ID, $service_id);
        $tokens = $this->getConsentLogins($c);
        return count($tokens)?$tokens[0]:null; 
    }
    
    public function hasSelectedHRSector($sector_id)
    {
        $c = new Criteria();
        $c->add(SelectedHRSectorPeer::SECTOR_ID, $sector_id);
        return count($this->getSelectedHRSectors($c));
    }
    
    public function getSelectedHRSector($sector_id)
    {
        $c = new Criteria();
        $c->add(SelectedHRSectorPeer::SECTOR_ID, $sector_id);
        return ($ss = $this->getSelectedHRSectors($c))?$ss[0]:null;
    }
    
    public function getSelectedHRSectorList()
    {
        $con = Propel::getConnection();
        $sql = "select * from emt_business_sector
                left join emt_selected_hr_sector on emt_business_sector.id=emt_selected_hr_sector.sector_id
                inner join emt_business_sector_i18n on emt_business_sector.id=emt_business_sector_i18n.id
                where emt_selected_hr_sector.user_id={$this->getId()} and emt_business_sector_i18n.culture='".sfContext::getInstance()->getUser()->getCulture()."'
                order by emt_business_sector_i18n.name";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return BusinessSectorPeer::populateObjects($stmt);
    }

    public function getActions()
    {
        $c = new Criteria();
        $c->add(ActionLogPeer::OBJECT_ID, $this->getId());
        $c->add(ActionLogPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->addAscendingOrderByColumn(ActionLogPeer::CREATED_AT);
        return ActionLogPeer::doSelect($c);
    }
    
    public function getContact()
    {
        $prof = $this->getUserProfile();
        if ($prof) return $prof->getContact();
        else return null;
    }
    
    public function getUserJob($job_id, $type_id, $c1 = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        if (is_numeric($job_id))
        {
            $c->add(UserJobPeer::JOB_ID, $job_id);
        }
        else
        {
            $c->addJoin(UserJobPeer::JOB_ID, JobPeer::ID, Criteria::LEFT_JOIN);
            $c->add(JobPeer::GUID, $job_id);
        }
        $c->add(UserJobPeer::TYPE_ID, $type_id);
        $c->setLimit(1);
        $ujs = $this->getUserJobs($c);
        return count($ujs)?$ujs[0]:null;
    }

    public function getUserJobsByTypeId($type_id, $return_job_object = true, $c1 = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        if ($return_job_object) $c->addJoin(UserJobPeer::JOB_ID, JobPeer::ID, Criteria::INNER_JOIN);
        $c->add(UserJobPeer::USER_ID, $this->getId());
        $c->add(UserJobPeer::TYPE_ID, $type_id);
        return $return_job_object ? JobPeer::doSelect($c) : UserJobPeer::doSelect($c);
    }

    public function getUserCompany($company_id, $type_id)
    {
        return $this->getBookmarkByItem($company_id, PrivacyNodeTypePeer::PR_NTYP_COMPANY, $type_id);
    }

    public function getUserGroup($group_id, $type_id)
    {
        return $this->getBookmarkByItem($group_id, PrivacyNodeTypePeer::PR_NTYP_GROUP, $type_id);
    }

    public function getUserCompaniesByTypeId($type_id)
    {
        return $this->getBookmarkByItem(null, PrivacyNodeTypePeer::PR_NTYP_COMPANY, $type_id);
    }
    
    public function getUserGroupsByTypeId($type_id)
    {
        return $this->getBookmarkByItem(null, PrivacyNodeTypePeer::PR_NTYP_GROUP, $type_id);
    }
    
    public function getBookmarkByItem($item_id = null, $item_type_id = null, $type_id = null)
    {
        $c = new Criteria();
        if ($item_id) $c->add(UserBookmarkPeer::ITEM_ID, $item_id);
        if ($item_type_id) $c->add(UserBookmarkPeer::ITEM_TYPE_ID, $item_type_id);
        if ($type_id) $c->add(UserBookmarkPeer::TYPE_ID, $type_id);
        $bm = $this->getUserBookmarks($c);
        return isset($item_id) && isset($item_type_id) && isset($type_id)  ? (count($bm) ? $bm[0] : null) : $bm;
    }
    
    public function isEmployed()
    {
        $c = new Criteria();
        $c->add(ResumeWorkPeer::PRESENT, 1);
        $res = $this->getResume();
        if ($res)
        {
            return $res->countResumeWorks($c);
        }
        else
        {
            return null;
        }
    }

    public function getGroup($id, $role_id = 13)
    {
        return ($g = $this->getGroupMembership($id, $role_id)) ? $g->getGroup() : null;
    }
    
    public function getGroupMembership($group_id, $role_id = null)
    {
        $c = new Criteria();
        $c->addJoin(GroupPeer::ID, GroupMembershipPeer::GROUP_ID, Criteria::INNER_JOIN);
        $c->add(GroupMembershipPeer::OBJECT_ID, $this->getId());
        $c->add(GroupMembershipPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        if (isset($role_id)) $c->add(GroupMembershipPeer::ROLE_ID, $role_id);
        $c->add(GroupMembershipPeer::STATUS, GroupMembershipPeer::STYP_ACTIVE);
        $c->add(GroupPeer::ID, $group_id);
        return GroupMembershipPeer::doSelectOne($c);
    }
    
    public function getGroupMemberships($role_id = null, $status = null, $get_groups = false, $keyword = null, $rand = false, $count = false, $page = null, $ipp = 20, $return_pager = false)
    {
        $get_groups = $count ? false : $get_groups;
        $joins = $wheres = array();

        $wheres[] = " (EMT_GROUP_MEMBERSHIP_VIEW.OBJECT_TYPE_ID=" . PrivacyNodeTypePeer::PR_NTYP_USER . "
                        AND
                      EMT_GROUP_MEMBERSHIP_VIEW.OBJECT_ID=" . ($this->getId() ? $this->getId() : 0). "
                      )";

        if ($role_id){
            $wheres[] = "RLS.ID=$role_id";
            $joins[] = " LEFT JOIN
                (
                    SELECT CONNECT_BY_ROOT ID SPOINT, ID, SYSNAME, LEVEL LVL FROM EMT_ROLE
                    START WITH PARENT_ID IS NOT NULL
                    CONNECT BY NOCYCLE PRIOR PARENT_ID = ID
                ) RLS ON EMT_GROUP_MEMBERSHIP_VIEW.ROLE_ID=RLS.SPOINT";
        }
        if ($status) $wheres[] = "EMT_GROUP_MEMBERSHIP_VIEW.STATUS=$status";
        if ($keyword)
        {
            $wheres[] = "(" . myTools::NLSFunc("EMT_GROUP_I18N.DISPLAY_NAME", 'UPPER'). " LIKE " . myTools::NLSFunc("'%$keyword%'", 'UPPER')
                            . " OR " . myTools::NLSFunc("EMT_GROUP.NAME", 'UPPER'). " LIKE " . myTools::NLSFunc("'%$keyword%'", 'UPPER')
                            . ")";
            $joins[] = " LEFT JOIN EMT_GROUP ON EMT_MEMBERSHIP_VIEW.GROUP_ID=EMT_GROUP.ID";
            $joins[] = " LEFT JOIN EMT_GROUP_I18N ON EMT_GROUP.ID=EMT_GROUP_I18N.ID AND EMT_GROUP_I18N.CULTURE='" . sfContext::getInstance()->getUser()->getCulture() . "'";
        }
        
        $sql = "SELECT EMT_GROUP_MEMBERSHIP_VIEW.*
                FROM EMT_GROUP_MEMBERSHIP_VIEW"
                . (count($joins) ? implode(' ', $joins) : "")
                . (count($wheres) ? " WHERE ". implode(' AND ', $wheres) : "");
        if ($get_groups)
        {
            $sql = "SELECT EMT_GROUP.*
                    FROM ($sql) MEMS
                    LEFT JOIN EMT_GROUP ON MEMS.GROUP_ID=EMT_GROUP.ID
                ";
            if (!$rand)
            $sql .= " LEFT JOIN EMT_GROUP_I18N ON EMT_GROUP.ID=EMT_GROUP_I18N.ID AND EMT_GROUP_I18N.CULTURE='".sfContext::getInstance()->getUser()->getCulture()."'
                     ORDER BY EMT_GROUP_I18N.DISPLAY_NAME";
        }
        
        if ($count)
        {
            $con = Propel::getConnection();
            $sql = "SELECT COUNT(*) FROM ($sql)";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_COLUMN, 0);
        }
        
        $sql .= $rand ? " ORDER BY dbms_random.value " : "";

        $pager = new EmtPager($get_groups ? 'Group' : 'GroupMembership', $ipp);
        $pager->setSql($sql);
        $pager->setPage($page);
        $pager->init();
        return $return_pager ? $pager : $pager->getResults();
    }

    public function getGroupById($group_id)
    {
        $c = new Criteria();
        $c->addJoin(GroupPeer::ID, GroupMembershipPeer::GROUP_ID, Criteria::INNER_JOIN);
        $c->add(GroupMembershipPeer::OBJECT_ID, $this->getId());
        $c->add(GroupMembershipPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(GroupMembershipPeer::ROLE_ID, RolePeer::RL_GP_OWNER);
        $c->add(GroupPeer::ID, $group_id);
        return GroupPeer::doSelectOne($c);
    }
    
    public function getGroups($role_id = null, $status = GroupMembershipPeer::STYP_ACTIVE)
    {
        $c = new Criteria();
        $c->addJoin(GroupPeer::ID, GroupMembershipPeer::GROUP_ID, Criteria::INNER_JOIN);
        $c->add(GroupMembershipPeer::OBJECT_ID, $this->getId());
        $c->add(GroupMembershipPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->setDistinct();
        if ($status) $c->add(GroupMembershipPeer::STATUS, $status);
        if ($role_id) $c->add(GroupMembershipPeer::ROLE_ID, $role_id);
        return GroupPeer::doSelect($c);
    }
    
    public function getStatusUpdate($id = null, $index = null)
    {
        $c = new Criteria();
        $c->add(StatusUpdatePeer::OBJECT_ID, $this->getId());
        $c->add(StatusUpdatePeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->addDescendingOrderByColumn(StatusUpdatePeer::CREATED_AT);
        return StatusUpdatePeer::doSelectOne($c);
    }
    
    public function setStatusUpdate($status)
    {
        if (!$this->getStatusUpdate() || ($status != $this->getStatusUpdate()->getMessage()))
        {
            $stu = new StatusUpdate();
            $stu->setObjectId($this->getId());
            $stu->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
            $stu->setMessage($status);
            $stu->save();
            ActionLogPeer::Log($this, ActionPeer::ACT_UPDATE_STATUS_MESSAGE, null, $stu);
        }
    }
    
    public function getLocationUpdate($id = null, $index = null)
    {
        $c = new Criteria();
        $c->add(LocationUpdatePeer::OBJECT_ID, $this->getId());
        $c->add(LocationUpdatePeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->addDescendingOrderByColumn(LocationUpdatePeer::CREATED_AT);
        return LocationUpdatePeer::doSelectOne($c);
    }
    
    public function getLocation()
    {
        $l = $this->getLocationUpdate();
        return $l?$l->getGeonameCity()->getName():null;
    }
    
    public function setLocationUpdate($city_id)
    {
        if ($city_id != (($l=$this->getLocationUpdate())?$l->getCity():null))
        {
            $c = new Criteria();
            $c->add(GeonameHierarchyPeer::CHILD_ID, $city_id);
            $city = GeonameHierarchyPeer::doSelectOne($c);
            if ($city)
            {
                $c = new Criteria();
                $c->addJoin(GeonameHierarchyPeer::PARENT_ID, GeonameCityPeer::GEONAME_ID, Criteria::INNER_JOIN);
                $c->add(GeonameHierarchyPeer::CHILD_ID, $city->getParentId());
                $c->add(GeonameHierarchyPeer::PARENT_ID, null, Criteria::ISNOTNULL);
                $c->add(GeonameCityPeer::FEATURE_CODE, 'CONT', Criteria::NOT_EQUAL);
                $parent = GeonameHierarchyPeer::doSelectOne($c);
                $state = $parent ? $parent->getChildId() : null;
                $country = ($g = $city->getGeonameCityRelatedByChildId()) ? $g->getCountryCode() : null;
            }
            else
            {
                $state = null;
                $country = null;
            }
            
            $lu = new LocationUpdate();
            $lu->setObjectId($this->getId());
            $lu->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
            $lu->setCountry($country);
            $lu->setCity($city_id);
            $lu->setState($state);
            $lu->save();
            ActionLogPeer::Log($this, ActionPeer::ACT_UPDATE_LOCATION, null, $lu);
        }
    }
    
    public function isOwnerOf($item_id, $item_type_id = null)
    {
        if (is_null($item_type_id) && is_object($item_id))
        {
            $owner = PrivacyNodeTypePeer::getTopOwnerOf($item_id);
            return $owner->getId() == $this->getId();
            $item_type_id = PrivacyNodeTypePeer::getTypeFromClassname(get_class($item_id));
            $item_id = $item_id->getId();
        }
        else
        {
            $object = PrivacyNodeTypePeer::retrieveObject($item_id, $item_type_id);
            if ($object) $owner = PrivacyNodeTypePeer::getTopOwnerOf($object);
            return $object ? $owner->getId() == $this->getId() : false;
        }
        
        
       //@todo: UPDATE TABLE NAMES WITH PROD NAMES
       $con = Propel::getConnection();
       switch ($item_type_id)
       {
           case PrivacyNodeTypePeer::PR_NTYP_COMPANY: 
                $sql = "SELECT count(*) FROM EMT_COMPANY_USER WHERE COMPANY_ID=$item_id AND OBJECT_ID=".($this->getId()?$this->getId():0)." AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND ROLE_ID=".RolePeer::RL_CM_OWNER;
                $stmt = $con->prepare($sql);
                $stmt->execute();
                return ($stmt->fetchColumn()>0) ? true : false;
                break; 
           case PrivacyNodeTypePeer::PR_NTYP_GROUP: 
                $sql = "SELECT count(*) FROM EMT_GROUP_MEMBERSHIP WHERE GROUP_ID=$item_id AND OBJECT_ID=".($this->getId()?$this->getId():0)." AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND ROLE_ID=".RolePeer::RL_GP_OWNER;
                $stmt = $con->prepare($sql);
                $stmt->execute();
                return ($stmt->fetchColumn()>0) ? true : false;
                break; 
           case PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM:
                $sql = "SELECT count(*) FROM EMT_MEDIA_ITEM WHERE ID={$item_id} AND OWNER_ID={$this->getId()} AND OWNER_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER;
                $stmt = $con->prepare($sql);
                $stmt->execute();
                return ($stmt->fetchColumn()>0) ? true : false;
                break;
           case PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM_FOLDER:
                $sql = "SELECT count(*) FROM EMT_MEDIA_ITEM_FOLDER WHERE ID={$item_id} AND OWNER_ID={$this->getId()} AND OWNER_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER;
                $stmt = $con->prepare($sql);
                $stmt->execute();
                return ($stmt->fetchColumn()>0) ? true : false;
                break;
           case PrivacyNodeTypePeer::PR_NTYP_COMMENT:
                $sql = "SELECT count(*) FROM EMT_COMMENT WHERE ID={$item_id} AND COMMENTER_ID={$this->getId()} AND COMMENTER_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER;
                $stmt = $con->prepare($sql);
                $stmt->execute();
                return ($stmt->fetchColumn()>0) ? true : false;
                break;
           default:
                return false;
       }
    }
   
    public function getCompanies($role_id = null)
    {
        $c = new Criteria();
        $c->addJoin(CompanyUserPeer::COMPANY_ID, CompanyPeer::ID);
        $c->add(CompanyUserPeer::OBJECT_ID, $this->getId());
        $c->add(CompanyUserPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        if ($role_id) $c->add(CompanyUserPeer::ROLE_ID, $role_id);
        return CompanyPeer::doSelect($c);
    }
   
    public function getOwnerships($include_plugs = false)
    {
        $owns = array_merge(array($this), $this->getCompanies(RolePeer::RL_CM_OWNER), $this->getGroups(RolePeer::RL_GP_OWNER));
        if ($include_plugs)
        {
            $hashed = array();
            foreach ($owns as $own)
            {
                $hashed[$own->getPlug()] = $own;
            }
            return $hashed;
        }
        return $owns;
    }

    public function isMemberOf($group_id, $role_id = null, $status = null)
    {
        $con = Propel::getConnection();
        $sql = "SELECT EMT_GROUP_MEMBERSHIP.*,
                RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                FROM EMT_GROUP_MEMBERSHIP
                WHERE OBJECT_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND GROUP_ID=$group_id".
                (isset($status) && !is_null($status) ? " AND STATUS=$status" : "") . 
                (isset($role_id) && !is_null($role_id) ? " AND ROLE_ID=$role_id" : "") . 
                "ORDER BY CREATED_AT DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $sps = GroupMembershipPeer::populateObjects($stmt);
        return count($sps) ? $sps[0] : null;
    }
    
    public function getSpouse()
    {
        $con = Propel::getConnection();
        $sql = "SELECT EMT_USER.* FROM EMT_RELATION
                INNER JOIN EMT_USER ON RELATED_USER_ID=EMT_USER.ID
                WHERE EMT_RELATION.USER_ID=".($this->getId()?$this->getId():0)." AND EMT_RELATION.ROLE_ID=".RolePeer::RL_SPOUSE." AND STATUS=".RelationPeer::RL_STAT_ACTIVE."
                UNION
                SELECT EMT_USER.* FROM EMT_RELATION
                INNER JOIN EMT_USER ON USER_ID=EMT_USER.ID
                WHERE EMT_RELATION.RELATED_USER_ID=".($this->getId()?$this->getId():0)." AND EMT_RELATION.ROLE_ID=".RolePeer::RL_SPOUSE." AND STATUS=".RelationPeer::RL_STAT_ACTIVE;
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $sps = UserPeer::populateObjects($stmt);
        return count($sps) ? $sps[0] : null;
    }
    
    public function isBlocked()
    {
        $c = new Criteria();
        $c->add(BlocklistPeer::LOGIN_ID, $this->getLogin()->getId());
        $c->add(BlocklistPeer::ACTIVE, 1);
        $blocks = BlocklistPeer::doSelect($c);
        if (count($blocks))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function getNetworkActivity($page = 1, $period_from = null, $period_to = null)
    {
        $con = Propel::getConnection();
        $sql = "SELECT DISTINCT * FROM 
                (
                    SELECT EMT_ACTION_LOG.* FROM EMT_ACTION_LOG, EMT_ACTION_CASE, EMT_ACTION, 
                    (
                        SELECT FRIEND_ID ITEM_ID, " . PrivacyNodeTypePeer::PR_NTYP_USER . " ITEM_TYPE_ID FROM
                        (
                          SELECT USER_ID, RELATED_USER_ID FRIEND_ID, ROLE_ID,
                          RANK() OVER (PARTITION BY RELATED_USER_ID, USER_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                          FROM EMT_RELATION
                          WHERE STATUS=" . RelationPeer::RL_STAT_ACTIVE . "
                          
                          UNION
                          
                          SELECT RELATED_USER_ID USER_ID, USER_ID FRIEND_ID, ROLE_ID,
                          RANK() OVER (PARTITION BY RELATED_USER_ID, USER_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                          FROM EMT_RELATION
                          WHERE STATUS=" . RelationPeer::RL_STAT_ACTIVE . "
        
                        )
                        WHERE (SEQNUMBER=1 AND USER_ID={$this->getId()})

                        UNION
                        
                        SELECT {$this->getId()}, 1 FROM DUAL 
                        
                        UNION 
                        
                        SELECT GROUP_ID ITEM_ID, " . PrivacyNodeTypePeer::PR_NTYP_GROUP . " ITEM_TYPE_ID FROM
                        (
                          SELECT GROUP_ID, 
                          RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                          FROM EMT_GROUP_MEMBERSHIP
                          WHERE OBJECT_ID={$this->getId()} AND OBJECT_TYPE_ID=" . PrivacyNodeTypePeer::PR_NTYP_USER . " AND STATUS=" . GroupMembershipPeer::STYP_ACTIVE . "
                        )
                        WHERE SEQNUMBER=1
                        
                        UNION
                        
                        SELECT COMPANY_ID ITEM_ID, " . PrivacyNodeTypePeer::PR_NTYP_COMPANY . " ITEM_TYPE_ID FROM
                        (
                          SELECT COMPANY_ID, 
                          RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                          FROM EMT_COMPANY_USER
                          WHERE OBJECT_ID={$this->getId()} AND OBJECT_TYPE_ID=" . PrivacyNodeTypePeer::PR_NTYP_USER . "
                        )
                        WHERE SEQNUMBER=1
                    ) RELATIONS
                    WHERE 
                        EMT_ACTION_LOG.ACTION_CASE_ID=EMT_ACTION_CASE.ID 
                        AND 
                        EMT_ACTION_CASE.ACTION_ID=EMT_ACTION.ID 
                        AND 
                        EMT_ACTION.DISPLAYABLE=1 
                        AND
                        (
                            (
                                EMT_ACTION_LOG.USER_ID=RELATIONS.ITEM_ID 
                                AND 
                                RELATIONS.ITEM_TYPE_ID=1
                            )
                            OR
                            (
                                EMT_ACTION_LOG.ISSUER_ID=RELATIONS.ITEM_ID 
                                AND 
                                EMT_ACTION_CASE.ISSUER_TYPE_ID=RELATIONS.ITEM_TYPE_ID
                            )
                            OR
                            (
                                EMT_ACTION_LOG.TARGET_ID=RELATIONS.ITEM_ID 
                                AND 
                                EMT_ACTION_CASE.TARGET_TYPE_ID=RELATIONS.ITEM_TYPE_ID
                            )
                        )
                        " .
                        ($period_from ? " AND EMT_ACTION_LOG.CREATED_AT > '$period_from' " : "").
                        ($period_to ? " AND EMT_ACTION_LOG.CREATED_AT < '$period_to' " : "").
                        "
                    ORDER BY CREATED_AT DESC 
                )
                WHERE ROWNUM > " . (($page-1)*25) . " AND ROWNUM <= " . ($page*25) . "
                ORDER BY CREATED_AT DESC
               ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return ActionLogPeer::populateObjects($stmt);
    }
    
    public function getAdjective()
    {
        return $this->getGender()===UserProfilePeer::GENDER_MALE ? 'his' : 'her';
    }

    public function getCurrentEmployments($single=false)
    {
        $c = new Criteria();
        $c->addJoin(ResumePeer::ID, ResumeWorkPeer::RESUME_ID, Criteria::LEFT_JOIN);
        $c->add(ResumePeer::USER_ID, $this->getId());
        $c->add(ResumeWorkPeer::PRESENT, 1);
        $c->addDescendingOrderByColumn(ResumeWorkPeer::DATE_FROM);
        return $single ? ResumeWorkPeer::doSelectOne($c) : ResumeWorkPeer::doSelect($c);
    }
    
    public function getCurrentEducations($single=false)
    {
        $c = new Criteria();
        $c->addJoin(ResumeSchoolPeer::RESUME_ID, ResumePeer::ID, Criteria::LEFT_JOIN);
        $c->add(ResumePeer::USER_ID, $this->getId());
        $c->add(ResumeSchoolPeer::PRESENT, 1);
        $c->addDescendingOrderByColumn(ResumeSchoolPeer::DATE_FROM);
        return $single ? ResumeSchoolPeer::doSelectOne($c) : ResumeSchoolPeer::doSelect($c);
    }
    
    public function getCareerLabel($type = 0)
    {
        $crr = array();
        if ($type == ResumePeer::CAREER_WORK || $type == ResumePeer::CAREER_BOTH)
        {
            $work = $this->getCurrentEmployments(true);
            $crr[] = $work ? sfContext::getInstance()->getI18n()->__('%1p, %2c', array('%1p' => $work->getJobTitle(), '%2c' => $work->getCompanyName())) : null;
        }
        if ($type == ResumePeer::CAREER_EDUCATION || $type == ResumePeer::CAREER_BOTH)
        {
            $school = $this->getCurrentEducations(true);
            $crr[] = $school ? sfContext::getInstance()->getI18n()->__('Studying %3m(%1d) at %2s', array('%1d' => $school->getResumeSchoolDegree(), '%2s' => $school->getSchool(), '%3m' => $school->getMajor())) . "<br />" : null;
        }

        return $type == ResumePeer::CAREER_BOTH ? $crr : (count($crr) ? $crr[0] : null);
    }
    
    public function setupUserProfile()
    {
        $p = new UserProfile();
        $p->setCreatedAt(time());
        $p->save();
        return $p;
    }
    
    public function getPreferredCulture($default = null)
    {
        $cults = sfConfig::get('app_i18n_cultures');
        
        $prof = $this->getUserProfile();
        if ($prof && in_array($prof->getPreferredLanguage(), $cults))
        {
            return $prof->getPreferredLanguage();
        }
        return $default;
    }
    
    public function getProfileTabsForUser($user)
    {
        $tabs = array();
        
        if ($user->can(ActionPeer::ACT_VIEW_PERSONAL_INFO, $this))
        {
            $tabs['info']     = array('Info', $this->getProfileActionUrl('info'));
        }
        if ($user->can(ActionPeer::ACT_VIEW_CAREER, $this))
        {
            $tabs['career']   = array('Career', $this->getProfileActionUrl('career'));
        }
        if ($user->can(ActionPeer::ACT_VIEW_FRIENDS, $this))
        {
            $tabs['friends']  = array('Friends', $this->getProfileActionUrl('friends'));
        }
        if ($user->can(ActionPeer::ACT_VIEW_FOLLOWS, $this))
        {
            $tabs['companies'] = array('Companies', $this->getProfileActionUrl('companies'));
        }
        if ($user->can(ActionPeer::ACT_VIEW_GROUPS, $this))
        {
            $tabs['groups']   = array('Groups', $this->getProfileActionUrl('groups'));
        }
        
        return $tabs;
    }
    
    public function hasIgnoredUser($user_id)
    {
        $c = new Criteria();
        $c->add(IgnoreAdvisePeer::RELATED_USER_ID, $user_id);
        return $this->countIgnoreAdvisesRelatedByUserId($c);
    }
    
    public function getCartUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . "viewcart";  
    }
    
    public function addToCart($package_id, $cus_id, $cus_type_id)
    {
        $cart = sfContext::getInstance()->getUser()->getAttribute('emtcart', array(), '/myemt/account/cart');
        
        if (!isset($cart[$cus_type_id])) $cart[$cus_type_id] = array();
        if (!isset($cart[$cus_type_id][$cus_id])) $cart[$cus_type_id][$cus_id] = array();
        
        $cart[$cus_type_id][$cus_id][] = $package_id;
        sfContext::getInstance()->getUser()->setAttribute('emtcart', $cart, '/myemt/account/cart');
    }
    
    public function removeFromCart($package_id, $cus_id, $cus_type_id)
    {
        $cart = sfContext::getInstance()->getUser()->getAttribute('emtcart', array(), '/myemt/account/cart');
        
        $pos = array_search($package_id, $cart);
        unset($cart[$pos]);
        
        sfContext::getInstance()->getUser()->setAttribute('emtcart', $cart, '/myemt/account/cart');
    }
    
    public function emptyCart()
    {
        sfContext::getInstance()->getUser()->setAttribute('emtcart', array(), '/myemt/account/cart');
    }
    
    public function getCart()
    {
        return sfContext::getInstance()->getUser()->getAttribute('emtcart', array(), '/myemt/account/cart');
    }
    
    public function getTransferProcess($transfer_guid = null, $status_id = null, $role_type_id = null, $return_single = true)
    {
        $role_matrix = array(TransferOwnershipRequestPeer::ROLE_CURRENT_OWNER => TransferOwnershipRequestPeer::CURRENT_OWNER_ID,
                             TransferOwnershipRequestPeer::ROLE_NEW_OWNER => TransferOwnershipRequestPeer::NEW_OWNER_ID,
                             TransferOwnershipRequestPeer::ROLE_ISSUER => TransferOwnershipRequestPeer::PROCESS_INIT_BY_ID
                        );

        $c = new Criteria();
        if (isset($status_id)) $c->add(TransferOwnershipRequestPeer::STATUS, $status_id, is_array($status_id) ? Criteria::IN : Criteria::EQUAL);
        if (isset($role_type_id))
        {
            $c->add($role_matrix[$role_type_id], $this->getId());
        }
        else
        {
            $c1 = $c->getNewCriterion(TransferOwnershipRequestPeer::PROCESS_INIT_BY_ID, $this->getId());
            $c2 = $c->getNewCriterion(TransferOwnershipRequestPeer::CURRENT_OWNER_ID, $this->getId());
            $c3 = $c->getNewCriterion(TransferOwnershipRequestPeer::NEW_OWNER_ID, $this->getId());
            $c1->addOr($c2);
            $c1->addOr($c3);
            $c->addAnd($c1);
        }
        if (isset($transfer_guid)) $c->add(TransferOwnershipRequestPeer::GUID, $transfer_guid);
        
        $c->addDescendingOrderByColumn(TransferOwnershipRequestPeer::CREATED_AT);
        
        return $return_single ? TransferOwnershipRequestPeer::doSelectOne($c) : TransferOwnershipRequestPeer::doSelect($c);
    }

    public function getActivityLevelInGroup($group_id)
    {
        // this function should evaluate the users group activity and return a numeric value
        $p = array('1 per week', '3 per day', '18 per month', '4 per day', '6 per week', '34 per week', '57 per month');
        return $p[array_rand($p)];
    }

    public function getConnections($type_id = null, $role_id = null, $role_hierarchy = true, $return_objects = true, $row_num = 20, $shuffle = false, $ipp = 0, $page = null, $criterias = array(), $get_asset_type = null, $count = false)
    {
        if (!isset($criterias['wheres'])) $criterias['wheres'] = array();
        if (!isset($criterias['joins'])) $criterias['joins'] = array();

        $subject_id = $this->isNew() ? 0 : $this->getId();
        $subject_type_id = PrivacyNodeTypePeer::PR_NTYP_USER;
        $tabarr = array(
            PrivacyNodeTypePeer::PR_NTYP_USER       => array("LEFT JOIN EMT_USER ON P_OBJECT_ID=EMT_USER.ID", 'NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE EMT_USER.LOGIN_ID=EMT_BLOCKLIST.LOGIN_ID AND EMT_BLOCKLIST.ACTIVE=1)', 'User'),
            PrivacyNodeTypePeer::PR_NTYP_COMPANY    => array('LEFT JOIN EMT_COMPANY ON P_OBJECT_ID=EMT_COMPANY.ID', 'EMT_COMPANY.BLOCKED!=1', 'Company'),
            PrivacyNodeTypePeer::PR_NTYP_GROUP      => array('LEFT JOIN EMT_GROUP ON P_OBJECT_ID=EMT_GROUP.ID', 'EMT_GROUP.BLOCKED!=1', 'Group'),
            null                                    => array('', '', '')
        );
        
        $relevelpos = array(
            PrivacyNodeTypePeer::PR_NTYP_USER           => UserPeer::NUM_COLUMNS,
            PrivacyNodeTypePeer::PR_NTYP_COMPANY        => CompanyPeer::NUM_COLUMNS,
            PrivacyNodeTypePeer::PR_NTYP_GROUP          => GroupPeer::NUM_COLUMNS,
            PrivacyNodeTypePeer::PR_NTYP_PRODUCT        => ProductPeer::NUM_COLUMNS,
            PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD       => B2bLeadPeer::NUM_COLUMNS,
            PrivacyNodeTypePeer::PR_NTYP_EVENT_INVITE   => EventInvitePeer::NUM_COLUMNS,
            PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT   => TradeExpertPeer::NUM_COLUMNS,
            PrivacyNodeTypePeer::PR_NTYP_JOB            => JobPeer::NUM_COLUMNS
        );
        
        if ($get_asset_type)
        {
            $assetlinks = array(
                PrivacyNodeTypePeer::PR_NTYP_PRODUCT        => "INNER JOIN EMT_PRODUCT ON COMPANY.ID=EMT_PRODUCT.COMPANY_ID",
                PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD       => "INNER JOIN EMT_B2B_LEAD ON COMPANY.ID=EMT_B2B_LEAD.COMPANY_ID",
                PrivacyNodeTypePeer::PR_NTYP_EVENT_INVITE   => "INNER JOIN EMT_EVENT_INVITE ON P_OBJECT_ID=EMT_EVENT_INVITE.SUBJECT_ID AND P_OBJECT_TYPE_ID=EMT_EVENT_INVITE.SUBJECT_TYPE_ID",
                PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT   => "INNER JOIN EMT_TRADE_EXPERT ON P_OBJECT_ID=EMT_TRADE_EXPERT.HOLDER_ID AND P_OBJECT_TYPE_ID=EMT_TRADE_EXPERT.HOLDER_TYPE_ID",
                PrivacyNodeTypePeer::PR_NTYP_JOB            => "INNER JOIN EMT_JOB ON P_OBJECT_ID=EMT_JOB.OWNER_ID AND P_OBJECT_TYPE_ID=EMT_JOB.OWNER_TYPE_ID"
            );
                
        }

        $row_num = ($ipp && $page) ? null : $row_num;
        
        $roles = is_array($role_id) ? $role_id : ($role_id ? array($role_id) : array());

        $c1 = implode(' AND ', array_filter(array(
            ($type_id ? "P_OBJECT_TYPE_ID=$type_id" : null),
            (count($roles) ? "p_hrole_id IN (".implode(',', $roles).")" : null)
        )));
        
        $sql = "
SELECT * FROM
(
    SELECT RES.*, RANK() OVER (PARTITION BY P_OBJECT_TYPE_ID, P_OBJECT_ID ORDER BY DEPTH) PRIO FROM 
    (
        SELECT CONNECT_OBJECT_ID, CONNECT_OBJECT_TYPE_ID, CONNECT_ROLE_ID, SROLES.ID S_ROLE_ID, SROLES.LVL S_RLVL, P_OBJECT_ID, P_OBJECT_TYPE_ID, P_SUBJECT_ID, P_SUBJECT_TYPE_ID, OROLES.ID P_HROLE_ID, OROLES.SPOINT P_ROLE_ID, OROLES.LVL P_RLVL, DEPTH FROM 
        (
            SELECT CONNECT_BY_ROOT P_OBJECT_ID CONNECT_OBJECT_ID, CONNECT_BY_ROOT P_OBJECT_TYPE_ID CONNECT_OBJECT_TYPE_ID, CONNECT_BY_ROOT T_ROLE_ID CONNECT_ROLE_ID , RELS.*, LEVEL DEPTH
            FROM 
            (
                SELECT 
                    OBJECT_ID P_OBJECT_ID, 
                    ".PrivacyNodeTypePeer::PR_NTYP_USER." P_OBJECT_TYPE_ID, 
                    SUBJECT_ID P_SUBJECT_ID, 
                    ".PrivacyNodeTypePeer::PR_NTYP_USER." P_SUBJECT_TYPE_ID, 
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
                WHERE STATUS=".GroupMembershipPeer::STYP_ACTIVE."
          
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
                    EMT_ROLE.OPPOSITE_ROLE_ID T_ROLE_ID
                FROM EMT_COMPANY_USER_VIEW
                LEFT JOIN EMT_ROLE ON EMT_COMPANY_USER_VIEW.ROLE_ID=EMT_ROLE.ID
                WHERE STATUS=".CompanyUserPeer::CU_STAT_ACTIVE." AND EMT_ROLE.OPPOSITE_ROLE_ID IS NOT NULL

            ) RELS
            START WITH P_SUBJECT_ID=$subject_id AND P_SUBJECT_TYPE_ID=$subject_type_id
            CONNECT BY NOCYCLE (PRIOR P_OBJECT_ID=P_SUBJECT_ID AND PRIOR P_OBJECT_TYPE_ID=P_SUBJECT_TYPE_ID AND LEVEL < ".(count($roles) ? 2 : 4)." AND (P_OBJECT_ID!=$subject_id OR P_OBJECT_TYPE_ID!=$subject_type_id))
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
        ".(!$role_hierarchy ? " WHERE oroles.id=oroles.spoint AND sroles.id=sroles.spoint" : "")." 
    ) res
    ".($c1 ? " WHERE $c1" : "")."
    ".(!$get_asset_type ? "ORDER BY ".($shuffle ? "dbms_random.value" : "s_rlvl, p_rlvl") : "")."
)
WHERE PRIO=1 
".(!$get_asset_type && $row_num ? " AND ROWNUM<=$row_num" : "")." 
    ";
        
        $class = $peer = null;
        
        if ($return_objects)
        {
            $class = $type_id ? $tabarr[$type_id][2] : 'BULKRESULT';
            $peer = $type_id ? $class.'Peer' : '';
        
            $sql = "
    SELECT DISTINCT ".($peer ? $peer::TABLE_NAME .".*, DEPTH, P_ROLE_ID" : "*" )." FROM
    ($sql)
    ".$tabarr[$type_id][0]."
    ".(!($get_asset_type && isset($assetlinks[$get_asset_type])) && isset($criterias['joins']) && count($criterias['joins']) ? implode(' ', $criterias['joins']) : "")."
    ".($type_id ? "WHERE ".$tabarr[$type_id][1] : "")."
    ".(!($get_asset_type && isset($assetlinks[$get_asset_type])) && isset($criterias['wheres']) && count($criterias['wheres']) ? ($type_id ? 'AND' : ' WHERE '). ' ('.implode(' OR ', $criterias['wheres']).')' : "")."
            ";
        }
        elseif (count($criterias['wheres']) || count($criterias['joins']))
        {
            $sql = "
    SELECT * FROM
    ($sql)
    ".(isset($criterias['joins']) && count($criterias['joins']) ? implode(' ', $criterias['joins']) : "")."
    ".(isset($criterias['wheres']) && count($criterias['wheres']) ? ' WHERE ('.implode(' OR ', $criterias['wheres']).')' : "")."
            ";
        }
        
        if ($get_asset_type && isset($assetlinks[$get_asset_type]))
        {
            $smtr = array_flip(PrivacyNodeTypePeer::$matrix);
            $class1 = $smtr[$get_asset_type];
            $peer1 = "{$class1}Peer";
            $sql = "
    SELECT * FROM (
        SELECT ".($peer1::TABLE_NAME).".*, DEPTH, P_ROLE_ID FROM
        ($sql) $class
        ".$assetlinks[$get_asset_type]."
    ".(isset($criterias['joins']) && count($criterias['joins']) ? implode(' ', $criterias['joins']) : "")."
    ".(isset($criterias['wheres']) && count($criterias['wheres']) ? 'WHERE ('.implode(' OR ', $criterias['wheres']).')' : "")."
    ORDER BY ".($shuffle ? "dbms_random.value" : "DEPTH")."
    )
    ".($row_num ? "WHERE ROWNUM <= $row_num" : "");
            $peer = $peer1;
            $class = $class1;
        }
        
        if ($count)
        {
            $sql = "SELECT COUNT(*) FROM (
                        SELECT DISTINCT P_OBJECT_ID, P_OBJECT_TYPE_ID FROM ($sql)
                    )";
        }
        
        if ($ipp && $page)
        {
            $pager = new EmtPager($class, $ipp);
            $pager->setPage($page);
            $pager->setSql($sql);
            $pager->setBindColumns(array('relevel' => $relevelpos[($get_asset_type ? $get_asset_type : $type_id)],
                                         'role_id' => $relevelpos[($get_asset_type ? $get_asset_type : $type_id)] + 1));
            $pager->init();
            return $pager;
        }
        else
        {
            $con = Propel::getConnection();
            $stmt = $con->prepare($sql);
            $stmt->execute();

            if ($count) return $stmt->fetch(PDO::FETCH_COLUMN, 0);
            
            if (!$return_objects) return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $objects = array();

            while ($row = $stmt->fetch(PDO::FETCH_NUM))
            {
                $obj = new $class();
                $obj->hydrate($row, 0);
                $obj->relevel = array_pop($row);
                $objects[] = $obj;
            }
            return $objects;
        }
    }

    public function getTradeExpertsAccount($status = null)
    {
        return TradeExpertPeer::retrieveAccountFor($status, $this);
    }
    
    public function getLocationLabel($type = ContactPeer::HOME)
    {
        $adr = ($cnt = $this->getContact()) ? $cnt->getAddressByType($type) : null;
        return $adr ? implode(', ', array_filter(array($adr->getGeonameCity(), CountryPeer::retrieveByISO($adr->getCountry())))) : null;
    }

    public function likes($item)
    {
        $c = new Criteria();
        $c->add(LikeItPeer::POSTER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(LikeItPeer::POSTER_ID, $this->isNew() ? null : $this->getId(), $this->isNew() ? Criteria::ISNULL : null);
        $c->add(LikeItPeer::ITEM_ID, $item->getId());
        $c->add(LikeItPeer::ITEM_TYPE_ID, $item->getObjectTypeId());
        return LikeItPeer::doSelectOne($c);
    }
    
    public function canApplyToJob($job)
    {
        return (!($ujob = $this->getUserJob($job->getId(), UserJobPeer::UJTYP_APPLIED)) || $ujob->getStatusId() == UserJobPeer::UJ_STATUS_TERMINATED);
    }
    
    public function getManagableRoles()
    {
        $c = new Criteria();
        $c->addJoin(RolePeer::ID, RoleAssignmentPeer::ROLE_ID, Criteria::RIGHT_JOIN);
        $c->add(RoleAssignmentPeer::LOGIN_ID, $this->getLoginId());
        $c->add(RolePeer::MODULE, null, Criteria::ISNOTNULL);
        return RolePeer::doSelect($c);
    }

    public function getPosts($viewer_user = null)
    {
        $viewer_id = is_null($viewer_user) ? sfContext::getInstance()->getUser()->getUser()->getId() : $viewer_user->getId();
        $viewer_id = is_null($viewer_id) ? 0 : $viewer_id;

        $con = Propel::getConnection();

        $sql = "
            SELECT DISTINCT EMT_WALL_POST.* 
            FROM EMT_WALL_POST
            LEFT JOIN (
                SELECT USER_ID FUSER, RELATED_USER_ID TUSER, ROLE_ID 
                FROM EMT_RELATION_VIEW 
                WHERE STATUS=".RelationPeer::RL_STAT_ACTIVE."

                UNION ALL

                SELECT RELATED_USER_ID FUSER, USER_ID TUSER, 
                CASE
                WHEN EMT_ROLE.OPPOSITE_ROLE_ID IS NOT NULL THEN EMT_ROLE.OPPOSITE_ROLE_ID
                ELSE EMT_ROLE.ID
                END ROLE_ID 
                FROM EMT_RELATION_VIEW
                LEFT JOIN EMT_ROLE ON EMT_RELATION_VIEW.ROLE_ID=EMT_ROLE.ID
                WHERE STATUS=".RelationPeer::RL_STAT_ACTIVE."
                
                UNION ALL
                
                SELECT ID, $viewer_id, ".RolePeer::RL_ALL." FROM EMT_USER
            ) RELS ON EMT_WALL_POST.POSTER_ID=RELS.FUSER AND TUSER=$viewer_id

            LEFT JOIN
            (
                select connect_by_root id spoint, id, sysname, level lvl from emt_role
                start with parent_id is not null
                connect by nocycle prior parent_id = id
            ) OROLES ON RELS.ROLE_ID=OROLES.SPOINT

            WHERE EMT_WALL_POST.DELETED_AT IS NULL AND AVAILABLE=1 
                AND EMT_WALL_POST.TARGET_AUDIENCE=OROLES.ID AND EMT_WALL_POST.OWNER_TYPE_ID={$this->getObjectTypeId()} AND EMT_WALL_POST.OWNER_ID=".($this->getId() ? $this->getId() : 0)."

            ORDER BY EMT_WALL_POST.CREATED_AT DESC
        ";

        $stmt = $con->prepare($sql);
        $stmt->execute();
        return WallPostPeer::populateObjects($stmt);
    }

    public function getDefineText()
    {
        return $this->__toString();
    }

    public function getEventsPager($page, $items_per_page = 20, $c1 = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(EventPeer::OWNER_ID, $this->getId());
        $c->add(EventPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        
        $pager = new sfPropelPager('Event', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }

    public function getEvents($c1 = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria;
        }
        
        $c->add(EventPeer::OWNER_ID, $this->getId());
        $c->add(EventPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);

        return EventPeer::doSelect($c); 
    }
    
    public function countEvents($c1 = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria;
        }
        
        $c->add(EventPeer::OWNER_ID, $this->getId());
        $c->add(EventPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);

        return EventPeer::doCount($c); 
    }
    
    public function getEvent($id)
    {
        $c = new Criteria();
        $c->add(EventPeer::ID, $id);
        $event = $this->getEvents($c);
        return count($events)?$events[0]:null;
    }
    
    public function getEventsByTypeId($typeid)
    {
        $c = new Criteria();
        $c->add(EventPeer::TYPE_ID, $typeid);
        return $this->getEvents($c);
    }
    
    public function getEventsByPeriod($p_const_id, $count = false)
    {
        $con = Propel::getConnection();

        $sql = EventPeer::$sqls[$p_const_id];
        
        if ($count)
        {
            $sql = "
                SELECT COUNT(*) FROM ($sql)
            ";
        }
        
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':OWNER_TYPE_ID', PrivacyNodeTypePeer::PR_NTYP_USER);
        $stmt->bindValue(':OWNER_ID', $this->getId());
        $stmt->execute();
        
        return $count ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : EventPeer::populateObjects($stmt);
    }
    
    public function countEventsByPeriod($p_const_id)
    {
        return $this->getEventsByPeriod($p_const_id, true);
    }

    public function getCommonFriends($user_id, $keyword = NULL, $rand=false, $count = false, $page = null, $ipp = 20, $return_pager = false)
    {
        $wheres = array();
        if ($keyword)
            $wheres[] = myTools::NLSFunc("EMT_USER.DISPLAY_NAME || ' ' || EMT_USER.DISPLAY_LASTNAME", 'UPPER') . " LIKE " . myTools::NLSFunc("'%$keyword%'", 'UPPER');
        
        $sql = "
            SELECT DISTINCT EMT_USER.* FROM
            (
                SELECT USER_ID FRIEND_ID
                FROM EMT_RELATION_VIEW
                WHERE STATUS=".RelationPeer::RL_STAT_ACTIVE." AND RELATED_USER_ID=$user_id
                UNION ALL
                SELECT RELATED_USER_ID FRIEND_ID
                FROM EMT_RELATION_VIEW
                WHERE STATUS=".RelationPeer::RL_STAT_ACTIVE." AND USER_ID=$user_id
            ) REF_USER
            LEFT JOIN EMT_USER ON REF_USER.FRIEND_ID=EMT_USER.ID
            WHERE FRIEND_ID IN
            ( 
                SELECT RELATED_USER_ID USER_ID
                FROM EMT_RELATION_VIEW
                WHERE STATUS=".RelationPeer::RL_STAT_ACTIVE." AND USER_ID=".($this->getId() ? $this->getId() : 0)."

                UNION ALL

                SELECT USER_ID
                FROM EMT_RELATION_VIEW
                WHERE STATUS=".RelationPeer::RL_STAT_ACTIVE." AND RELATED_USER_ID=".($this->getId() ? $this->getId() : 0)."
            )
            AND NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE EMT_BLOCKLIST.LOGIN_ID=EMT_USER.LOGIN_ID AND EMT_BLOCKLIST.ACTIVE=1)
            ".(count($wheres) ? " AND " . implode(' AND ', $wheres) : '')."
            ".($rand ? " ORDER BY dbms_random.value" : '')."
        ";
        
        if ($count)
        {
            $con = Propel::getConnection();
            $sql = "SELECT COUNT(*) FROM ($sql)";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_COLUMN, 0);
        }
        
        $pager = new EmtPager('User', $ipp);
        $pager->setSql($sql);
        $pager->setPage($page);
        $pager->init();
        return $return_pager ? $pager : $pager->getResults();
    }

    public function getMediaItemPager($page, $items_per_page = 20, $c1 = null, $item_type = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        if (isset($item_type)) $c->add(MediaItemPeer::ITEM_TYPE_ID, $item_type);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        
        $pager = new sfPropelPager('MediaItem', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }

}