<?php

class Group extends BaseGroup
{
    private $hash = null;
    
    public function __toString()
    {
        return $this->getName(); 
    }
    
    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_GROUP;
    }
    
    public function setName($name)
    {
        parent::setName($name);
        
        $this->setStrippedName(myTools::url_slug($name));
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_GROUP) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getDisplayName($culture = null)
    {
      return $this->getCurrentGroupI18n($culture)->getDisplayName() ? $this->getCurrentGroupI18n($culture)->getDisplayName() : $this->getName();
    }
    
    public function getManageUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . "group-manage?action=manage&hash={$this->getHash()}";  
    }
    
    public function getProfilePictureUri($size = MediaItemPeer::LOGO_TYP_SMALL)
    {
        $logo = $this->getLogo();
        if ($logo)
        {
            switch ($size)
            {
                case MediaItemPeer::LOGO_TYPE_MEDIUM :
                    return $logo->getMediumUri();
                    break;
                case MediaItemPeer::LOGO_TYPE_LARGE :
                    return $logo->getUri();
                    break;
                case MediaItemPeer::LOGO_TYP_SMALL :
                default: 
                    return $logo->getThumbnailUri();
                    break;
            }
        }
        else
        {
            switch ($size)
            {
                case MediaItemPeer::LOGO_TYPE_MEDIUM :
                    return "layout/background/nologo.medium.png";
                    break;
                case MediaItemPeer::LOGO_TYPE_LARGE :
                    return "layout/background/nologo.png";
                    break;
                case MediaItemPeer::LOGO_TYP_SMALL :
                default: 
                    return "layout/background/nologo.thumb.png";
                    break;
            }
        }
    }

    public function setProfilePictureId($mi_id)
    {
        $logo = $this->getLogo();
        
        $mitem = MediaItemPeer::retrieveByPK($mi_id);

        $con = Propel::getConnection();
        if ($mitem)
        {
            try
            {
                $con->beginTransaction();

                if ($logo)
                {
                    $logo->setItemTypeId(MediaItemPeer::MI_TYP_ALBUM_PHOTO);
                    $logo->save();
                }
                
                $mitem->setItemTypeId(MediaItemPeer::MI_TYP_LOGO);
                $mitem->save();
                $con->commit();
            }
            catch (Exception $e)
            {
                $con->rollBack();
            }
        }
        
        ActionLogPeer::Log($this, ActionPeer::ACT_UPLOAD_LOGO, null, $mitem);
    }
    
    public function getProfilePictureId()
    {
        return $this->getLogo()?$this->getLogo()->getId():null;
    }
    
    public function getLogo()
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_LOGO);
        $logo_ar = $this->getMediaItems($c);
        if (is_array($logo_ar) && count($logo_ar))
            return $logo_ar[0];
        else
            return null;
    }
    
    public function setLogo($mediaitem)
    {
        if (!($imediaitem instanceof MediaItem)) return null;
        
        $oldlogo = $this->getLogo();
        $con = Propel::getConnection();
        if ($mediaitem)
        {
            try
            {
                $con->beginTransaction();
    
                if ($oldlogo)
                {
                    $oldlogo->setItemTypeId(MediaItemPeer::MI_TYP_ALBUM_PHOTO);
                    $oldlogo->save();
                }
                $mediaitem->setItemTypeId(MediaItemPeer::MI_TYP_LOGO);
                $mediaitem->save();

                $con->commit();
            }
            catch (Exception $e)
            {
                $con->rollBack();
                return false;
            }
            return true;
        }
        return false;
    }
    
    public function getExistingI18ns()
    {
        if ($this->isNew())
        {
            return array();
        }
        else
        {
            $con = Propel::getConnection();
            
            $sql = "SELECT CULTURE FROM EMT_GROUP_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(GroupI18nPeer::ID, $this->getId());
        $c->add(GroupI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return GroupI18nPeer::doDelete($c);
    }
    
    public function getMediaItems($c1 = null)
    {
        if (is_int($c1))
        {
            return MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, $c1);
        }
        
        if ($c1)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        
        return MediaItemPeer::doSelect($c);
    }
    
    public function getProfileUrl()
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "camp")
        return "@group-profile?stripped_name=".$this->getStrippedName();
        else
        return "@camp.group-profile?stripped_name=".$this->getStrippedName();
    }

    public function getPhotosUrl($paramstr = null)
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "camp")
            return "@group-photos?stripped_name=".$this->getStrippedName().(isset($paramstr) ? "&$paramstr" : "");
        else
            return "@camp.group-photos?stripped_name=".$this->getStrippedName().(isset($paramstr) ? "&$paramstr" : "");
    }
    
    public function getUploadUrl()
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "camp")
            return "@group-upload-photo?stripped_name=".$this->getStrippedName();
        else
            return "@camp.group-upload-photo?stripped_name=".$this->getStrippedName();
    }
    
    public function getPhoto($mi_id)
    {
        $item = MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, MediaItemPeer::MI_TYP_ALBUM_PHOTO, $mi_id);
        if (!$item) $item = MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, MediaItemPeer::MI_TYP_LOGO, $mi_id);
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
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $c1 = $c->getNewCriterion(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_ALBUM_PHOTO);
        $c2 = $c->getNewCriterion(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_LOGO);
        $c1->addOr($c2);
        $c->addAnd($c1);
        return $count ? MediaItemPeer::doCount($c) : MediaItemPeer::doSelect($c);
    }
    
    public function getUnreadMessageCount()
    {
        $con = Propel::getConnection();
        
        $sql = "SELECT count(*) FROM ".MessageRecipientPeer::TABLE_NAME."
                WHERE ".MessageRecipientPeer::IS_READ."=0 AND
                      ".MessageRecipientPeer::RECIPIENT_ID."=".$this->getId()." AND
                      ".MessageRecipientPeer::RECIPIENT_TYPE_ID."=".PrivacyNodeTypePeer::PR_NTYP_GROUP." AND
                      ".MessageRecipientPeer::FOLDER_ID."=".MessagePeer::MFOLDER_INBOX." AND
                      ".MessageRecipientPeer::DELETED_AT." IS NULL
                ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $rs = $stmt->fetch(PDO::FETCH_NUM);
        return $rs[0];
    }

    public function getTotalUsedStorage()
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        $c->clearSelectColumns();
        $c->addAsColumn('TOTALSIZE', "sum(".MediaItemPeer::FILE_SIZE.")");
        
        $res = BasePeer::doSelect($c);
        $res->execute();
        $value = $res->fetch(PDO::FETCH_ASSOC);
        return $value['TOTALSIZE']?$value['TOTALSIZE']:0;
    }
    
    public function createFolder($name, $type)
    {
        try
        {
            $f = new MediaItemFolder();
            $f->setName($name);
            $f->setOwnerId($this->id);
            $f->setOwnerTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
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
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $c->add(MediaItemFolderPeer::OWNER_ID, $this->id);
        if (isset($type)) $c->add(MediaItemFolderPeer::TYPE_ID, $type);
        return MediaItemFolderPeer::doSelect($c);
    }
    
    public function getFolder($id, $type=null)
    {
        $c = new Criteria();
        $c->add(MediaItemFolderPeer::ID, $id);
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $c->add(MediaItemFolderPeer::OWNER_ID, $this->id);
        if (isset($type)) $c->add(MediaItemFolderPeer::TYPE_ID, $type);
        return MediaItemFolderPeer::doSelectOne($c);
    }
    
    public function getFolderByName($name, $type=null)
    {
        $c = new Criteria();
        $c->add(MediaItemFolderPeer::NAME, $name);
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $c->add(MediaItemFolderPeer::OWNER_ID, $this->id);
        if (isset($type)) $c->add(MediaItemFolderPeer::TYPE_ID, $type);
        return MediaItemFolderPeer::doSelectOne($c);
    }
    
    public function getFolderByType($type)
    {
        $c = new Criteria();
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
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
    
    public function getAvailableStorage()
    {
        return 100*1024*1024;
    }
    
    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentGroupI18n($culture);
        return $lsi->isNew()?false:true;
    }
    
    public function countFollowers($type_id = null)
    {
        return $this->getMembers($type_id, true, false, RolePeer::RL_GP_FOLLOWER);
    }
    
    public function getFollowers($type_id = null, $rand = false)
    {
        return $this->getMembers($type_id, false, $rand, RolePeer::RL_GP_FOLLOWER);
    }
    
    public function countMembers($type_id = null, $role_id = null, $return_array = false)
    {
        $cnt_mem = $this->getMembers($type_id, true, false, $role_id);
        return $return_array ? $cnt_mem : array_sum($cnt_mem);
        
    }
    
    public function getMembers($type_id = null, $count = false, $rand = false, $role_id = null)
    {
        $con = Propel::getConnection();
        
        $sqls = array(
            PrivacyNodeTypePeer::PR_NTYP_USER => "
                SELECT " . ($count ? "COUNT(*)" : "EMT_USER.*") . " FROM EMT_GROUP_MEMBERSHIP
                LEFT JOIN EMT_USER ON EMT_GROUP_MEMBERSHIP.OBJECT_ID=EMT_USER.ID
                WHERE EMT_GROUP_MEMBERSHIP.GROUP_ID={$this->getId()} AND EMT_GROUP_MEMBERSHIP.STATUS=".GroupMembershipPeer::STYP_ACTIVE." AND EMT_GROUP_MEMBERSHIP.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER
                ." AND NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE EMT_BLOCKLIST.LOGIN_ID=EMT_USER.LOGIN_ID AND EMT_BLOCKLIST.ACTIVE=1)"
                .($role_id?" AND EMT_GROUP_MEMBERSHIP.ROLE_ID=$role_id":"")
                .(!$count ? "ORDER BY " . ($rand ? "dbms_random.value" : "NLSSORT(NAME,'NLS_SORT=GENERIC_M_CI'), NLSSORT(LASTNAME,'NLS_SORT=GENERIC_M_CI')") : ""),
            PrivacyNodeTypePeer::PR_NTYP_COMPANY => "
                SELECT " . ($count ? "COUNT(*)" : "EMT_COMPANY.*") . " FROM EMT_GROUP_MEMBERSHIP
                LEFT JOIN EMT_COMPANY ON EMT_GROUP_MEMBERSHIP.OBJECT_ID=EMT_COMPANY.ID
                LEFT JOIN EMT_COMPANY_USER ON EMT_COMPANY.ID=EMT_COMPANY_USER.COMPANY_ID
                LEFT JOIN EMT_USER ON EMT_COMPANY_USER.OBJECT_ID=EMT_USER.ID
                WHERE EMT_GROUP_MEMBERSHIP.GROUP_ID={$this->getId()} AND EMT_GROUP_MEMBERSHIP.STATUS=".GroupMembershipPeer::STYP_ACTIVE." AND EMT_GROUP_MEMBERSHIP.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY
                ." AND EMT_COMPANY_USER.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND EMT_COMPANY_USER.ROLE_ID=".RolePeer::RL_CM_OWNER
                ." AND NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE EMT_BLOCKLIST.LOGIN_ID=EMT_USER.LOGIN_ID AND EMT_BLOCKLIST.ACTIVE=1)"
                ." AND EMT_COMPANY.BLOCKED!=1"
                .($role_id?" AND EMT_GROUP_MEMBERSHIP.ROLE_ID=$role_id":"")
                .(!$count ? "ORDER BY " . ($rand ? "dbms_random.value" : "NLSSORT(NAME,'NLS_SORT=GENERIC_M_CI')") : ""),
        );

        $atts = array();

        foreach ($sqls as $type => $sql)
        {
            if ($type_id && $type != $type_id) continue;
            
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            if ($count)
            {
                $atts[$type] = $stmt->fetch(PDO::FETCH_COLUMN, 0); 
            }
            else
            {
                switch ($type)
                {
                    case PrivacyNodeTypePeer::PR_NTYP_USER : $atts[$type] = UserPeer::populateObjects($stmt);
                        break;
                    case PrivacyNodeTypePeer::PR_NTYP_COMPANY : $atts[$type] = CompanyPeer::populateObjects($stmt);
                        break;
                }
            }
        }
        
        return $type_id ? $atts[$type_id] : $atts;
    }
    
    public function getLinkedGroups($keyword = null, $role_id = null, $status = null, $count = false)
    {
        if (!isset($role_id)) $role_id = RolePeer::RL_GP_LINKED_GROUP;

        $con = Propel::getConnection();
        $sql = "SELECT " . ($count ? "COUNT(*)" : "EMT_GROUP.*") . " FROM
                (
                    SELECT EMT_GROUP_MEMBERSHIP_VIEW.*
                    FROM EMT_GROUP_MEMBERSHIP_VIEW
                    LEFT JOIN
                    (
                        select connect_by_root id spoint, id, sysname, level lvl from emt_role
                        start with parent_id is not null
                        connect by nocycle prior parent_id = id
                        
                        union all
                        
                        select id spoint, id, sysname, 1 from emt_role where id=21
                        
                        union all
                        
                        select id spoint, id, sysname, 1 from emt_role where id=0
                    ) rls ON EMT_GROUP_MEMBERSHIP_VIEW.ROLE_ID=rls.spoint
                    WHERE OBJECT_ID=:group_id AND OBJECT_TYPE_ID=:group_type_id AND rls.id=:role_id
                    ".($status?" AND STATUS " . (is_array($status) ? "IN (".implode(',', $status).")" : "=$status" ) :"") ."

                    UNION ALL

                    SELECT EMT_GROUP_MEMBERSHIP_VIEW.*
                    FROM EMT_GROUP_MEMBERSHIP_VIEW
                    LEFT JOIN
                    (
                        select connect_by_root id spoint, id, sysname, opposite_role_id, level lvl from emt_role
                        start with parent_id is not null
                        connect by nocycle prior parent_id = id
                        
                        union all
                        
                        select id spoint, id, sysname, opposite_role_id, 1 from emt_role where id=21
                        
                        union all
                        
                        select id spoint, id, sysname, opposite_role_id, 1 from emt_role where id=0
                    ) rls ON EMT_GROUP_MEMBERSHIP_VIEW.ROLE_ID=rls.spoint
                    WHERE GROUP_ID=:group_id AND OBJECT_TYPE_ID=:group_type_id AND rls.OPPOSITE_ROLE_ID=:role_id
                    ".($status?" AND STATUS " . (is_array($status) ? "IN (".implode(',', $status).")" : "=$status" ) :"") . "
                ) EGRP
                LEFT JOIN EMT_GROUP ON EGRP.OBJECT_ID=EMT_GROUP.ID
                LEFT JOIN EMT_GROUP_MEMBERSHIP_VIEW OMEM ON EMT_GROUP.ID=OMEM.GROUP_ID
                LEFT JOIN EMT_USER ON OMEM.OBJECT_ID=EMT_USER.ID AND OMEM.OBJECT_TYPE_ID=:user_type_id
                WHERE OMEM.ROLE_ID=:gp_owner_role_id
                      AND NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE EMT_BLOCKLIST.LOGIN_ID=EMT_USER.LOGIN_ID AND EMT_BLOCKLIST.ACTIVE=1)
                      AND EMT_GROUP.BLOCKED!=1"
                .($keyword?" AND UPPER(EMT_GROUP.NAME) LIKE UPPER(:keyword)":"")
                .(!$count ? "ORDER BY NLSSORT(EMT_GROUP.NAME,'NLS_SORT=GENERIC_M_CI')" : "");

        $stmt = $con->prepare($sql);
        $stmt->bindValue(':group_id', $this->getId());
        $stmt->bindValue(':group_type_id', PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $stmt->bindValue(':role_id', $role_id);
        $stmt->bindValue(':user_type_id', PrivacyNodeTypePeer::PR_NTYP_USER);
        $stmt->bindValue(':gp_owner_role_id', RolePeer::RL_GP_OWNER);
        if ($keyword) $stmt->bindValue('keyword', $keyword);
        $stmt->execute();
        return $count ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : GroupPeer::populateObjects($stmt);
    }

    public function hasMembership($obj_id, $obj_type_id)
    {
        $filter = array(GroupMembershipPeer::STYP_BANNED,
                        GroupMembershipPeer::STYP_PENDING,
                        GroupMembershipPeer::STYP_REJECTED_BY_MOD,
                        GroupMembershipPeer::STYP_REJECTED_BY_USER);
                        
        $con = Propel::getConnection();
        $sql = "SELECT * FROM
                (
                    SELECT EMT_GROUP_MEMBERSHIP.*,
                    RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                    FROM EMT_GROUP_MEMBERSHIP
                )   
                WHERE SEQNUMBER=1 AND GROUP_ID={$this->getId()} AND OBJECT_ID=$obj_id AND OBJECT_TYPE_ID=$obj_type_id
                AND STATUS NOT IN (" . implode(',',$filter) . ")
                ";
                
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $mm = GroupMembershipPeer::populateObjects($stmt);
        return count($mm) ? $mm[0] : null;
    }
    
    public function getMembership($object_id = null, $object_type_id = null, $role_id = null, $status = null)
    {
        if (!(($object_id && $object_type_id) || $role_id)) return null;
        
        $statuscr = isset($status) && !is_array($status) ? array($status) : $status;
        
        $con = Propel::getConnection();
        
        if ($object_type_id == PrivacyNodeTypePeer::PR_NTYP_GROUP)
        {
            $filter = array(GroupMembershipPeer::STYP_BANNED,
                            GroupMembershipPeer::STYP_INVITED,
                            GroupMembershipPeer::STYP_PENDING,
                            GroupMembershipPeer::STYP_REJECTED_BY_MOD,
                            GroupMembershipPeer::STYP_REJECTED_BY_USER,
                            GroupMembershipPeer::STYP_ENDED_BY_STARTER_USER,
                            GroupMembershipPeer::STYP_ENDED_BY_TARGET_USER,
                            GroupMembershipPeer::STYP_USER_LEFT);

            $opprole = array(RolePeer::RL_GP_PARENT_GROUP => RolePeer::RL_GP_SUBSIDIARY_GROUP,
                             RolePeer::RL_GP_SUBSIDIARY_GROUP => RolePeer::RL_GP_PARENT_GROUP);
            $sql = "SELECT * FROM
                    (
                        SELECT EMT_GROUP_MEMBERSHIP.*,
                        RANK() OVER (PARTITION BY GROUP_ID, OBJECT_ID, OBJECT_TYPE_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                        FROM EMT_GROUP_MEMBERSHIP
                        WHERE OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_GROUP."
                    )   
                    WHERE SEQNUMBER=1 AND (GROUP_ID={$this->getId()} AND OBJECT_ID=$object_id ".(isset($role_id) ? (array_key_exists($role_id, $opprole) ? " AND ROLE_ID=$opprole[$role_id]" : "AND ROLE_ID=$role_id") :"" ).") OR (GROUP_ID=$object_id AND OBJECT_ID={$this->getId()}" . (isset($role_id) ? " AND ROLE_ID=$role_id" : "") . ")
                    AND " . (isset($status) ? "STATUS IN (" . implode(',', $statuscr) . ")" : " STATUS NOT IN (" . implode(',',$filter) . ")");
            
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $rr = GroupMembershipPeer::populateObjects($stmt);
            return count($rr) ? $rr[0] : null;
        }
        
        $sql = "SELECT * FROM 
                (
                    SELECT EMT_GROUP_MEMBERSHIP.*,
                    RANK() OVER (PARTITION BY GROUP_ID, OBJECT_ID, OBJECT_TYPE_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                    FROM EMT_GROUP_MEMBERSHIP
                )
                WHERE SEQNUMBER=1 AND GROUP_ID={$this->getId()} AND OBJECT_TYPE_ID!=".PrivacyNodeTypePeer::PR_NTYP_GROUP
                .(isset($object_id) ? " AND OBJECT_ID=$object_id AND OBJECT_TYPE_ID=$object_type_id" : "")
                .(isset($role_id) ? " AND ROLE_ID=$role_id" : "")
                .(isset($status) ? " AND STATUS IN (".implode(',', $statuscr).")" : "");
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $cus = GroupMembershipPeer::populateObjects($stmt);
        
        return isset($object_id) && count($cus) ? $cus[0] : $cus;
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
            START WITH P_SUBJECT_ID=".sfContext::getInstance()->getUser()->getUser()->getId()." AND P_SUBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER."
            CONNECT BY NOCYCLE (PRIOR P_OBJECT_ID=P_SUBJECT_ID AND PRIOR P_OBJECT_TYPE_ID=P_SUBJECT_TYPE_ID AND LEVEL < 3 AND (P_OBJECT_ID!=".sfContext::getInstance()->getUser()->getUser()->getId()." OR P_OBJECT_TYPE_ID!=".PrivacyNodeTypePeer::PR_NTYP_USER."))
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
        WHERE (CONNECT_OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_GROUP." AND CONNECT_OBJECT_ID={$this->getId()} AND DEPTH=2)
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
) 
WHERE 
(
  (
    (
      (p_subject_id=subject_id and subject_type_id=p_subject_type_id) or subject_id is null
    )
    and 
    (
      (p_object_id=object_id and object_type_id=p_object_type_id) or object_id is null
    )
  )  
  and 
  ((p_role_id=role_on_object and p_object_type_id=object_type_id) or (role_on_object is null and p_rlvl=1))
  and 
  ((s_role_id=role_on_subject and p_subject_type_id=subject_type_id) or (role_on_subject is null and s_rlvl=1))
  and 
  (p_object_type_id is not null)
  and 
  (
    (p_subject_id=".($this->getId()?$this->getId():0) ." and subject_type_id=".PrivacyNodeTypePeer::PR_NTYP_GROUP." and p_object_id=$object_id and p_object_type_id=$object_type_id) or
    (p_subject_id is null and p_role_id=".RolePeer::RL_ALL." and subject_type_id=".PrivacyNodeTypePeer::PR_NTYP_GROUP." and p_object_id=$object_id and p_object_type_id=$object_type_id and rownum=1)
  )
  and
  action_id=$action_id
)

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
    
    public function getStatusUpdate($id = null, $index = null)
    {
        $c = new Criteria();
        $c->add(StatusUpdatePeer::OBJECT_ID, $this->getId());
        $c->add(StatusUpdatePeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $c->addDescendingOrderByColumn(StatusUpdatePeer::CREATED_AT);
        return StatusUpdatePeer::doSelectOne($c);
    }
    
    public function setStatusUpdate($status)
    {
        if (!$this->getStatusUpdate() || ($status != $this->getStatusUpdate()->getMessage()))
        {
            $stu = new StatusUpdate();
            $stu->setObjectId($this->getId());
            $stu->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
            $stu->setMessage($status);
            $stu->save();
            ActionLogPeer::Log($this, ActionPeer::ACT_UPDATE_STATUS_MESSAGE, null, $stu);
        }
    }
        
    // This function will be removed in the future. Currently kept just for BC. (Renamed from countMembers) 
    public function countMembersByStatus($status = 1, Array $mem_type = null)
    {
        if (is_null($mem_type)) $mem_type = array(PrivacyNodeTypePeer::PR_NTYP_USER,
                                                  PrivacyNodeTypePeer::PR_NTYP_COMPANY,
                                                  PrivacyNodeTypePeer::PR_NTYP_GROUP);
        // default status selected to be GroupMembershipPeer::STYP_ACTIVE
        $con = Propel::getConnection();
        $sql = "SELECT SUM(CNT) FROM
                (
                " . 
            ( in_array(PrivacyNodeTypePeer::PR_NTYP_USER, $mem_type) ?
                "
                    SELECT COUNT(*) CNT FROM 
                    (
                        SELECT * FROM
                        (
                            SELECT EMT_GROUP_MEMBERSHIP.*,
                            RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                            FROM EMT_GROUP_MEMBERSHIP
                        )   
                        WHERE SEQNUMBER=1 AND STATUS=$status AND GROUP_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER."
                    ) MEMBERSHIP
                    LEFT JOIN EMT_USER ON MEMBERSHIP.OBJECT_ID=EMT_USER.ID
                " : "" ) .
            ( in_array(PrivacyNodeTypePeer::PR_NTYP_COMPANY, $mem_type) ?
                "
                    UNION
                    
                    SELECT COUNT(*) CNT FROM 
                    (
                        SELECT * FROM
                        (
                            SELECT EMT_GROUP_MEMBERSHIP.*,
                            RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                            FROM EMT_GROUP_MEMBERSHIP
                        )   
                        WHERE SEQNUMBER=1 AND STATUS=$status AND GROUP_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY."
                    ) MEMBERSHIP
                    LEFT JOIN EMT_COMPANY ON MEMBERSHIP.OBJECT_ID=EMT_COMPANY.ID
                " : "" ) .
            ( in_array(PrivacyNodeTypePeer::PR_NTYP_GROUP, $mem_type) ? 
                "
                    UNION
                    
                    SELECT COUNT(*) CNT FROM 
                    (
                        SELECT * FROM
                        (
                            SELECT EMT_GROUP_MEMBERSHIP.*,
                            RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                            FROM EMT_GROUP_MEMBERSHIP
                        )   
                        WHERE SEQNUMBER=1 AND STATUS=$status AND GROUP_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_GROUP."
                    ) MEMBERSHIP
                    LEFT JOIN EMT_GROUP ON MEMBERSHIP.OBJECT_ID=EMT_GROUP.ID
                " : "" ) .
                ")";
                        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN, 0);
    }
    
    public function getPeople($status = 1, $count = false)
    {
        // default status selected to be GroupMembershipPeer::STYP_ACTIVE
        $con = Propel::getConnection();
        $sql = "SELECT ".($count ? "COUNT(*)" : "EMT_USER.*")." FROM 
                (
                    SELECT * FROM
                    (
                        SELECT EMT_GROUP_MEMBERSHIP.*,
                        RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                        FROM EMT_GROUP_MEMBERSHIP
                    )   
                    WHERE SEQNUMBER=1 AND STATUS=$status AND GROUP_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER."
                ) MEMBERSHIP
                LEFT JOIN EMT_USER ON MEMBERSHIP.OBJECT_ID=EMT_USER.ID
                ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $count ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : UserPeer::populateObjects($stmt);
    }
    
    public function countPeople($status = null)
    {
        return $this->getPeople($status, true);
    }
    
    public function getBannedPeople($count = false)
    {
        return $this->getPeople(GroupMembershipPeer::STYP_BANNED, $count);
    }

    public function getPendingPeople($count = false)
    {
        return $this->getPeople(GroupMembershipPeer::STYP_PENDING, $count);
    }

    public function getActivePeople($count = false)
    {
        return $this->getPeople(GroupMembershipPeer::STYP_ACTIVE, $count);
    }

    public function getCompanies($status = 1, $count = false)
    {
        // default status selected to be GroupMembershipPeer::STYP_ACTIVE
        $con = Propel::getConnection();
        $sql = "SELECT ".($count ? "COUNT(*)" : "EMT_COMPANY.*")." FROM 
                (
                    SELECT * FROM
                    (
                        SELECT EMT_GROUP_MEMBERSHIP.*,
                        RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                        FROM EMT_GROUP_MEMBERSHIP
                    )   
                    WHERE SEQNUMBER=1 AND STATUS=$status AND GROUP_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY."
                ) MEMBERSHIP
                LEFT JOIN EMT_COMPANY ON MEMBERSHIP.OBJECT_ID=EMT_COMPANY.ID
                ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $count ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : CompanyPeer::populateObjects($stmt);
    }
    
    public function countCompanies($status = null)
    {
        return $this->getCompanies($status, true);
    }
    
    public function getBannedCompanies($count = false)
    {
        return $this->getCompanies(GroupMembershipPeer::STYP_BANNED, $count);
    }

    public function getPendingCompanies($count = false)
    {
        return $this->getCompanies(GroupMembershipPeer::STYP_PENDING, $count);
    }

    public function getActiveCompanies($count = false)
    {
        return $this->getCompanies(GroupMembershipPeer::STYP_ACTIVE, $count);
    }

    public function getGroups($status = 1, $count = false)
    {
        // default status selected to be GroupMembershipPeer::STYP_ACTIVE
        $con = Propel::getConnection();
        $sql = "SELECT ".($count ? "COUNT(*)" : "EMT_GROUP.*")." FROM 
                (
                    SELECT * FROM
                    (
                        SELECT EMT_GROUP_MEMBERSHIP.*,
                        RANK() OVER (PARTITION BY OBJECT_ID, OBJECT_TYPE_ID, GROUP_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                        FROM EMT_GROUP_MEMBERSHIP
                    )   
                    WHERE SEQNUMBER=1 AND STATUS=$status AND GROUP_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_GROUP."
                ) MEMBERSHIP
                LEFT JOIN EMT_GROUP ON MEMBERSHIP.OBJECT_ID=EMT_GROUP.ID
                ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $count ? $stmt->fetch(PDO::FETCH_NUM) : GroupPeer::populateObjects($stmt);
    }
    
    public function getBannedGroups($count = false)
    {
        return $this->getGroups(GroupMembershipPeer::STYP_BANNED, $count);
    }

    public function getPendingGroups($count = false)
    {
        return $this->getGroups(GroupMembershipPeer::STYP_PENDING, $count);
    }

    public function getActiveGroups($count = false)
    {
        return $this->getGroups(GroupMembershipPeer::STYP_ACTIVE, $count);
    }

    public function isMemberOf($group_id, $role_id = null, $status = null)
    {
        $c = new Criteria();
        $c->add(GroupMembershipPeer::OBJECT_ID, $this->getId());
        $c->add(GroupMembershipPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $c->add(GroupMembershipPeer::GROUP_ID, $group_id);
        if ($role_id) $c->add(GroupMembershipPeer::ROLE_ID, $role_id);
        $c->add(GroupMembershipPeer::STATUS, $status ? $status : GroupMembershipPeer::STYP_ACTIVE);
        return GroupMembershipPeer::doSelectOne($c);
    }
    
    public function addMember($item, $item_type_id = null)
    {
        if (is_object($item))
        {
            $item_type_id = PrivacyNodeTypePeer::getTypeFromClassname($item);
            $item_id = $item->getId();
        }
        else
        {
            $item_id = $item;
        }
        $membership = new GroupMembership();
        $membership->setObjectId($item_id);
        $membership->setObjectTypeId($item_type_id);
        $membership->setGroupId($this->getId());
        if ($this->getPublicity() == GroupPeer::GRP_PBL_OPEN)
        {
            $membership->setRoleId(RolePeer::RL_GP_MEMBER);
            $membership->setStatus(GroupMembershipPeer::STYP_ACTIVE);
            ActionLogPeer::Log($item, ActionPeer::ACT_JOIN_GROUP, $this);
        }
        else
        {
            $membership->setRoleId(RolePeer::RL_GP_CANDIDATE_MEMBER);
            $membership->setStatus(GroupMembershipPeer::STYP_PENDING);
        }
        $membership->save();

        return $membership;
    }
    
    public function getAdjective()
    {
        return 'its';
    }

    public function getOwner()
    {
        $con = Propel::getConnection();
        
        $sql = "
            SELECT EMT_USER.* FROM EMT_GROUP_MEMBERSHIP_VIEW GMVIEW
            LEFT JOIN EMT_USER ON GMVIEW.OBJECT_ID=EMT_USER.ID AND GMVIEW.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER."
            WHERE GMVIEW.STATUS=".GroupMembershipPeer::STYP_ACTIVE." AND GMVIEW.ROLE_ID=".RolePeer::RL_GP_OWNER."
                AND GMVIEW.GROUP_ID={$this->getId()}
        ";
        //Removed from SQL >   AND NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE LOGIN_ID=EMT_USER.LOGIN_ID AND ACTIVE=1)
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return count($usr = UserPeer::populateObjects($stmt)) ? $usr[0] : null;
    }
    
    public function getDefineText($to_user = null, $target_culture = null)
    {
        if (!$to_user) $to_user = sfContext::getInstance()->getUser()->getUser();
        $top_owner = PrivacyNodeTypePeer::getTopOwnerOf($this);
        $is_owner = ($top_owner && $to_user->getId() == $top_owner->getId()) ? true : false;
        $owner = $this->getOwner();

        $i18n = sfContext::getInstance()->getI18N();
        $cl = $i18n->getCulture();
        if ($target_culture)
        {
            $culture = $target_culture;
            $i18n->setCulture($culture);
        }
        else
        {
            $culture = $cl;
        }
    
        $result = "a group";
        
        $result = $is_owner ? $i18n->__("your group %1g", array('%1g' => $this)) : $i18n->__("%1u's group %2g", array('%1u' => $owner, '%2g' => $this));
        
        if ($target_culture) $i18n->setCulture($cl);
        return $result;
    }

	public function getProfileActionUrl($action)
    {
        $app = (sfContext::getInstance()->getConfiguration()->getApplication() == "camp") ? "@" : "@camp.";
        $route = ($action == "jobs") ? "group-jobs" : "group-profile-action";
        //$param = ($action == "jobs") ? "hash={$this->getHash()}" : "stripped_name={$this->getStrippedName()}";
        $param = "stripped_name={$this->getStrippedName()}";

        return "{$app}{$route}?$param&action=$action";
    }
    
    public function getProfileTabsForUser($user)
    {
        $tabs = array();
        
        if ($user->can(ActionPeer::ACT_VIEW_CONTACT_INFO, $this))
        {
            $tabs['info']     = array('Info', $this->getProfileActionUrl('info'));
        }
        if ($user->can(ActionPeer::ACT_VIEW_PEOPLE, $this))
        {
            $tabs['people']  = array('People', $this->getProfileActionUrl('people'));
        }
        if ($user->can(ActionPeer::ACT_VIEW_COMPANIES, $this))
        {
            $tabs['companies'] = array('Companies', $this->getProfileActionUrl('companies'));
        }
        if ($user->can(ActionPeer::ACT_VIEW_GROUPS, $this))
        {
            $tabs['groups']   = array('Groups', $this->getProfileActionUrl('groups'));
        }
/*
        if ($this->sesuser->can(ActionPeer::ACT_VIEW_EVENTS, $this->group))
        {
            $this->tabs['events']   = array('Events',       $this->getProfileActionUrl('groups'));
        }
*/
        
        return $tabs;
    }
    
    public function getHRProfile()
    {
        $c = new Criteria();
        $c->add(HRProfilePeer::OWNER_ID, $this->getId());
        $c->add(HRProfilePeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        return HRProfilePeer::doSelectOne($c);
    }

    public function getOwnerLastLoginDate($format = null)
    {
        $this->getOwner()->getLastLoginDate($format);
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
        $c->add(EventPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        
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
        $c->add(EventPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);

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
        $c->add(EventPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);

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
        $stmt->bindValue(':OWNER_TYPE_ID', PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $stmt->bindValue(':OWNER_ID', $this->getId());
        $stmt->execute();
        
        return $count ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : EventPeer::populateObjects($stmt);
    }
    
    public function countEventsByPeriod($p_const_id)
    {
        return $this->getEventsByPeriod($p_const_id, true);
    }
    
    public function getJobs(Criteria $c1 = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        $c->add(JobPeer::OWNER_ID, $this->getId());
        $c->add(JobPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        return JobPeer::doSelect($c);
    }
    
    public function countJobs(Criteria $c1 = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        $c->add(JobPeer::OWNER_ID, $this->getId());
        $c->add(JobPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        return JobPeer::doCount($c);
    }
    
    public function getJob($id)
    {
        $c = new Criteria();
        $c->add(JobPeer::ID, $id);
        $jobs = $this->getJobs($c);
        return count($jobs)?$jobs[0]:null;
    }
    
    public function getPurchaseItems($serviceID)
    {
        $c = new Criteria();
        $c->addJoin(PurchaseItemPeer::PURCHASE_ID, PurchasePeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(PurchaseItemPeer::PACKAGE_ID, MarketingPackagePeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(MarketingPackagePeer::ID, MarketingPackageItemPeer::PACKAGE_ID, Criteria::LEFT_JOIN);
        $c->addJoin(MarketingPackageItemPeer::SERVICE_ID, ServicePeer::ID, Criteria::LEFT_JOIN);
        $c->add(ServicePeer::ID, $serviceID);
        $c->add(PurchasePeer::BUYER_ID, $this->getId());
        $c->add(PurchasePeer::BUYER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $c->addAscendingOrderByColumn(PurchaseItemPeer::CREATED_AT);
        return PurchaseItemPeer::doSelect($c);
    }
    
    public function getJobsByPurchaseId($pid)
    {
        $c = new Criteria();
        $c->add(JobPeer::PURCHASE_ITEM_ID, $pid);
        return $this->getJobs($c);
    }
    
    public function countJobsByPurchaseId($pid)
    {
        $c = new Criteria();
        $c->add(JobPeer::PURCHASE_ITEM_ID, $pid);
        return $this->countJobs($c);
    }
    
    public function getOnlineJobs($number = null, $shuffle = false, $count = false)
    {
        $con = Propel::getConnection();
        $sql = "SELECT ".($count ? "count(*)" : "*")." FROM EMT_JOB_VIEW
                WHERE STATUS=".JobPeer::JSTYP_ONLINE."
                    AND OWNER_ID={$this->getId()} AND OWNER_TYPE_ID={$this->getObjectTypeId()}
                ".($shuffle ? "ORDER BY dbms_random.value" : '');
        if ($number && !$count)
        {
            $sql = "SELECT * FROM ($sql) WHERE ROWNUM < $number";
        }
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        return $count ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : JobPeer::populateObjects($stmt);
    }
    
    public function countOnlineJobs()
    {
        return $this->getOnlineJobs(null, null, true);
    }
    
    public function getOfflineJobs()
    {
        $c = new Criteria();
        $c->add(JobPeer::STATUS, JobPeer::JSTYP_OFFLINE);
        return $this->getJobs($c);
    }
    
    public function getJobPager($page, $items_per_page = 20, $c1 = null, $status = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        if (isset($status)) $c->add(JobPeer::STATUS, $status);
        $c->add(JobPeer::OWNER_ID, $this->getId());
        $c->add(JobPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        
        $pager = new sfPropelPager('Job', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }

    public function getTransferProcess($status_id, $return_single = true)
    {
        $c = new Criteria();
        $c->add(TransferOwnershipRequestPeer::ACCOUNT_ID, $this->getId());
        $c->add(TransferOwnershipRequestPeer::ACCOUNT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        $c->add(TransferOwnershipRequestPeer::STATUS, $status_id);
        $c->addDescendingOrderByColumn(TransferOwnershipRequestPeer::CREATED_AT);
        return $return_single ? TransferOwnershipRequestPeer::doSelectOne($c) : TransferOwnershipRequestPeer::doSelect($c);
    }
    
    public function getMemberPager($page, $items_per_page = 20, $c1 = null, $status = null, $type = null)
    {
        $arr = array(PrivacyNodeTypePeer::PR_NTYP_USER => 'User', PrivacyNodeTypePeer::PR_NTYP_COMPANY => 'Company');
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }

        if (isset($status)) $c->add(GroupMembershipPeer::STATUS, $status);
        $c->add(GroupMembershipPeer::GROUP_ID, $this->getId());
        $c->addJoin(GroupMembershipPeer::ID, 'EMT_GROUP_MEMBERSHIP_VIEW.ID', Criteria::RIGHT_JOIN);

        $pager = new sfPropelPager(isset($type) ? $arr[$type] : 'GroupMembership', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);

        $pager->init();
        return $pager;
    }
    
    public function getAnnouncements(Criteria $c1 = null)
    {
        if (isset($c1))
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(AnnouncementPeer::OWNER_ID, $this->getId());
        $c->add(AnnouncementPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        
        return AnnouncementPeer::doSelect($c);
    }

    public function getAnnouncementById($id)
    {
        $c = new Criteria();
        $c->add(AnnouncementPeer::ID, $id);
        $anns = $this->getAnnouncements($c);
        return count($anns) ? $anns[0] : null;
    }
    
    public function getAnnouncementsByDelivery($is_delivered = false)
    {
        $c = new Criteria();
        if  ($is_delivered)
        {
            $c->add(AnnouncementPeer::DELIVER_FROM, null, Criteria::ISNOTNULL);
            $c->add(AnnouncementPeer::DELIVER_FROM, AnnouncementPeer::DELIVER_FROM . ' < SYSDATE', Criteria::CUSTOM);
        }
        else
        {
            $c1 = $c->getNewCriterion(AnnouncementPeer::DELIVER_FROM, null, Criteria::ISNULL);
            $c2 = $c->getNewCriterion(AnnouncementPeer::DELIVER_FROM, AnnouncementPeer::DELIVER_FROM . ' > SYSDATE', Criteria::CUSTOM);
            $c1->addOr($c2);
            $c->add($c1);
        }
        return $this->getAnnouncements($c);
    }

    public function getLocationLabel($type = ContactPeer::WORK)
    {
        $adr = ($cnt = $this->getContact()) ? $cnt->getAddressByType($type) : null;
        return $adr ? implode(', ', array_filter(array($adr->getGeonameCity(), CountryPeer::retrieveByISO($adr->getCountry())))) : null;
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
                SELECT GROUP_ID FGROUP, OBJECT_ID TUSER, ROLE_ID 
                FROM EMT_GROUP_MEMBERSHIP_VIEW 
                WHERE STATUS=".RelationPeer::RL_STAT_ACTIVE." AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER."

                UNION ALL

                SELECT ID, $viewer_id, ".RolePeer::RL_ALL." FROM EMT_GROUP
            ) RELS ON EMT_WALL_POST.OWNER_ID=RELS.FGROUP AND EMT_WALL_POST.OWNER_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_GROUP." AND TUSER=$viewer_id

            LEFT JOIN
            (
                select connect_by_root id spoint, id, sysname, level lvl from emt_role
                start with parent_id is not null
                connect by nocycle prior parent_id = id
            ) OROLES ON RELS.ROLE_ID=OROLES.SPOINT

            WHERE EMT_WALL_POST.DELETED_AT_BY_OWNER IS NULL AND EMT_WALL_POST.DELETED_AT_BY_POSTER IS NULL AND AVAILABLE=1 
                AND EMT_WALL_POST.TARGET_AUDIENCE=OROLES.ID AND EMT_WALL_POST.OWNER_TYPE_ID={$this->getObjectTypeId()} AND EMT_WALL_POST.OWNER_ID=".($this->getId() ? $this->getId() : 0)."

            ORDER BY EMT_WALL_POST.CREATED_AT DESC
        ";

        $stmt = $con->prepare($sql);
        $stmt->execute();
        return WallPostPeer::populateObjects($stmt);
    }

    public function getConnections($type_id = null, $role_id = null, $role_hierarchy = true, $return_objects = true, $row_num = 20, $shuffle = false, $ipp = 0, $page = null, $criterias = array(), $get_asset_type = null, $count = false)
    {
        if (!isset($criterias['wheres'])) $criterias['wheres'] = array();
        if (!isset($criterias['joins'])) $criterias['joins'] = array();

        $subject_id = $this->isNew() ? 0 : $this->getId();
        $subject_type_id = PrivacyNodeTypePeer::PR_NTYP_GROUP;
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
                PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT   => "INNER JOIN EMT_TRADE_EXPERT ON P_OBJECT_ID=EMT_TRADE_EXPERT.HOLDER_ID AND P_OBJECT_TYPE_ID=EMT_TRADE_EXPERT.HOLDER_TYPE_ID"
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
        elseif ((isset($criterias['wheres']) && count($criterias['wheres'])) || (isset($criterias['joins']) && count($criterias['joins'])))
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
    ".(isset($criterias['joins']) && count($criterias['joins']) ? implode(' OR ', $criterias['joins']) : "")."
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
                $obj->role_id = array_pop($row);
                $obj->relevel = array_pop($row);
                $objects[] = $obj;
            }
            return $objects;
        }
    }

    public function getDiscussions($num = null, $count = false)
    {
        return $count ? 0 : array();
    }

    public function getTopDiscussions($num = null, $count = false)
    {
        return $count ? 0 : array();
    }

    public function getActiveDiscussions($num = null, $count = false)
    {
        return $count ? 0 : array();
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
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_GROUP);
        
        $pager = new sfPropelPager('MediaItem', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }

    public function isOnline()
    {
        return ($this->getAvailable() && !$this->getBlocked() && !$this->getOwner()->isBlocked());
    }

    public function getStatusCode()
    {
        if ($this->getBlocked()) {
            return GroupPeer::GRP_STAT_IS_SUSPENDED;
        }
        elseif (!$this->getAvailable()) {
            return GroupPeer::GRP_STAT_IS_UNPUBLISHED;
        }
        elseif ($this->getOwner()->isBlocked()) {
            return GroupPeer::GRP_STAT_OWNER_BLOCKED;
        }
        else {
            return GroupPeer::GRP_STAT_ONLINE;
        }
    }
    
    public function getStatusMessage()
    {
        return GroupPeer::$statMessages[$this->getStatusCode()];
    }

    public function getPremiumAccount($type_id = null)
    {
        return PremiumAccountPeer::getAccountFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, $type_id);
    }

    public function getMessageFolders()
    {
        return $this->getFolders(MediaItemFolderPeer::MIF_TYP_MESSAGE);
    }
}