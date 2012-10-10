<?php

class Company extends BaseCompany
{
    protected $aSentMessages=null;
    protected $aReceivedMessages=null;
    protected $aArchivedMessages=null;
    protected $UnreadMessageCount=null;

    private $hash = null;
        
    public function __toString()
    {
        return $this->getName();
    }
    
    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_COMPANY;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_COMPANY) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getProfilePicture()
    {
        return $this->getLogo();
    }

    public function getProfilePictureUri($size = MediaItemPeer::LOGO_TYP_SMALL)
    {
        $logo = $this->getLogo();
        if ($logo)
        {
            switch ($size)
            {
                case MediaItemPeer::LOGO_TYPE_ORIGINAL :
                    return $logo->getOriginalFileUri();
                    break;
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

    public function getProfileUrl()
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "b2b")
        return $this->hasAccountName()?"@company-profile-accountname?accountname=".$this->getAccountName():"@company-profile?hash=".$this->getHash();
        else
        return $this->hasAccountName()?"@b2b.company-profile-accountname?accountname=".$this->getAccountName():"@b2b.company-profile?hash=".$this->getHash();
    }

    public function getProfileActionUrl($action_name)
    {
        $current = sfContext::getInstance()->getConfiguration()->getApplication();
        $target = ($action_name == 'jobs' ? 'hr' : 'b2b');
        if ($action_name == 'jobs') return "@".($current!=$target? "$target." : '')."company-jobs?hash={$this->getHash()}";
        return "@".($current!=$target? "$target." : '')."company-profile-action?hash={$this->getHash()}&action=$action_name";
    }

    public function hasAccountName()
    {
        return false;
    }

    // This function will be removed in the future. Currently kept just for BC. 
    public function getPeople($keyword = NULL)
    {
        return $this->getFollowers($keyword);
    }

    // This function will be removed in the future. Currently kept just for BC. 
    public function countConnectedPeople()
    {
        return $this->getFollowers(null, true);
    }

    public function countFollowers()
    {
        return $this->getFollowers(null, true);
    }

    public function getFollowers($keyword = NULL, $count = false, $rand = true)
    {
        $con = Propel::getConnection();
        $sql = "SELECT "  . ($count ? "COUNT(*)" : "EMT_USER.*") . "  FROM EMT_COMPANY
                LEFT JOIN EMT_COMPANY_USER_VIEW ON EMT_COMPANY.ID=EMT_COMPANY_USER_VIEW.COMPANY_ID
                LEFT JOIN EMT_USER ON EMT_COMPANY_USER_VIEW.OBJECT_ID=EMT_USER.ID
                WHERE EMT_COMPANY.ID=:company_id AND EMT_COMPANY_USER_VIEW.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER."
                 AND EMT_COMPANY_USER_VIEW.ROLE_ID=" . RolePeer::RL_CM_FOLLOWER
                ." AND NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE EMT_BLOCKLIST.LOGIN_ID=EMT_USER.LOGIN_ID AND EMT_BLOCKLIST.ACTIVE=1)"
                .($keyword?" AND ".myTools::NLSFunc(UserPeer::NAME . " || ' ' || " . UserPeer::LASTNAME, 'UPPER')." LIKE " . myTools::NLSFunc(":keyword", 'UPPER') : "")
                .(!$count ? " ORDER BY " . ($rand ? "dbms_random.value" : myTools::NLSFunc(UserPeer::NAME, 'SORT'). ',' . myTools::NLSFunc(UserPeer::LASTNAME, 'SORT')) : "");

        $stmt = $con->prepare($sql);
        $stmt->bindValue(':company_id', $this->getId());
        if ($keyword) $stmt->bindValue(':keyword', $keyword);
        $stmt->execute();
        return $count ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : UserPeer::populateObjects($stmt);
    }

    public function countPartners($keyword = null, $role_id = null, $status = null)
    {
        return $this->getPartners($keyword, $role_id, $status, true);
    }
    
    public function getPartners($keyword = null, $role_id = null, $status = null, $count = false)
    {
        $statarr = is_array($status) ? $status : array($status);

        $roles = is_array($role_id) ? $role_id : $role_id ? array($role_id) : array(RolePeer::RL_CM_PARTNER);

        $con = Propel::getConnection();
        $sql = "SELECT " . ($count ? "COUNT(*)" : "EMT_COMPANY.*, PROLE_ID") . " FROM
                (
                    SELECT EMT_COMPANY_USER_VIEW.OBJECT_ID COMPANY_ID, EMT_COMPANY_USER_VIEW.ROLE_ID PROLE_ID,
                    RANK() OVER (PARTITION BY COMPANY_ID, OBJECT_ID, OBJECT_TYPE_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                    FROM EMT_COMPANY_USER_VIEW
                    left join
                    (
                        select connect_by_root id spoint, id, sysname, level lvl from emt_role
                        start with parent_id is not null
                        connect by nocycle prior parent_id = id
                    ) rls on emt_company_user_view.role_id=rls.spoint
                    WHERE COMPANY_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY."
                    AND rls.id IN (".implode(',', $roles).")
                    ".($status ? " AND STATUS IN (".implode(',', $statarr).")" :"") ."

                    UNION

                    SELECT EMT_COMPANY_USER_VIEW.COMPANY_ID COMPANY_ID, rls.opposite_role_id PROLE_ID,
                    RANK() OVER (PARTITION BY COMPANY_ID, OBJECT_ID, OBJECT_TYPE_ID ORDER BY CREATED_AT DESC) SEQNUMBER
                    FROM EMT_COMPANY_USER_VIEW
                    left join
                    (
                        select connect_by_root id spoint, id, sysname, connect_by_root opposite_role_id opposite_role_id, level lvl from emt_role
                        start with parent_id is not null
                        connect by nocycle prior parent_id = id
                    ) rls on emt_company_user_view.role_id=rls.spoint
                    WHERE OBJECT_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY."
                    AND rls.opposite_role_id IN (".implode(',', $roles).")
                    ".($status ? " AND STATUS IN (".implode(',', $statarr).")" : "") . "
                ) ECOMP
                LEFT JOIN EMT_COMPANY ON ECOMP.COMPANY_ID=EMT_COMPANY.ID
                LEFT JOIN EMT_COMPANY_USER_VIEW ON EMT_COMPANY.ID=EMT_COMPANY_USER_VIEW.COMPANY_ID
                LEFT JOIN EMT_USER ON EMT_COMPANY_USER_VIEW.OBJECT_ID=EMT_USER.ID AND EMT_COMPANY_USER_VIEW.OBJECT_TYPE_ID=1
                WHERE EMT_COMPANY_USER_VIEW.OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND EMT_COMPANY_USER_VIEW.ROLE_ID=".RolePeer::RL_CM_OWNER
                ." AND NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE EMT_BLOCKLIST.LOGIN_ID=EMT_USER.LOGIN_ID AND EMT_BLOCKLIST.ACTIVE=1)"
                ." AND EMT_COMPANY.BLOCKED!=1"
                .($keyword?" AND UPPER(ECOMP.NAME) LIKE UPPER('%$keyword%')":"")
                .(!$count ? " ORDER BY ".myTools::NLSFunc(CompanyPeer::NAME, 'SORT') : "");
        $stmt = $con->prepare($sql);
        if ($keyword) $stmt->bindValue('keyword', $keyword);
        $stmt->execute();
        if (!$count)
        {
            $companies = array();
            while ($row = $stmt->fetch(PDO::FETCH_NUM))
            {
                $cm = new Company();
                $cm->hydrate($row, 0);
                $cm->relation_role_id = $row[CompanyPeer::NUM_COLUMNS];
                $companies[] = $cm;
            }
            return $companies;
        }
        return $stmt->fetch(PDO::FETCH_COLUMN, 0);
    }

    public function getContactedCountries()
    {
        $con = Propel::getConnection();
        $sql = "select count(*) as mescount, emt_contact_address.country as country,
                (100*count(*)/(select count(*) from emt_message 
                left join emt_message_recipient on emt_message.id=emt_message_recipient.message_id
                where emt_message.sender_type_id=2 and emt_message_recipient.recipient_id=".$this->getId()." and emt_message_recipient.recipient_type_id=2)) as percent 
                from emt_contact_address
                left join emt_contact on emt_contact.id=emt_contact_address.contact_id
                left join emt_company_profile on emt_company_profile.contact_id=emt_contact.id
                left join emt_company on emt_company.profile_id=emt_company_profile.id
                left join emt_message on emt_message.sender_id=emt_company.id
                left join emt_message_recipient on emt_message_recipient.message_id=emt_message.id
                where emt_message.sender_type_id=2 and emt_message_recipient.recipient_type_id=2 and emt_message_recipient.recipient_id=".$this->getId()."
                group by emt_contact_address.country
                order by percent desc";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    
    public function getMostViewedProducts($count=5)
    {
        $con = Propel::getConnection();
        $sql = "select emt_product.*, rating  from (
                    select emt_rating.item_id as rid, count(*) as rating from emt_rating where emt_rating.item_type_id=".RatingPeer::RITYP_PRODUCT." group by emt_rating.item_id order by rating desc
                    )
                inner join emt_product on emt_product.id=rid
                where emt_product.company_id=".$this->getId()." and emt_product.active=1 and rownum<=$count
                ";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return ProductPeer::populateObjects($stmt);
    }
    
    public function countMessages($c1 = null)
    {
        if ($c1)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        $c->addJoin(MessagePeer::ID, MessageRecipientPeer::MESSAGE_ID, Criteria::LEFT_JOIN);
        $c->add(MessageRecipientPeer::RECIPIENT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->add(MessageRecipientPeer::RECIPIENT_ID, $this->id);
        $c->add(MessageRecipientPeer::FOLDER_ID, MessagePeer::MFOLDER_INBOX);
        $c->add(MessageRecipientPeer::DELETED_AT, null, Criteria::ISNULL);
        $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
        return MessagePeer::doCount($c);
    }
    
    public function getMessages($c1=null)
    {
        if (is_null($this->aReceivedMessages))
        {
            if ($c1)
            {
                $c = clone $c1;
            }
            else
            {
                $c = new Criteria();
            }
            $c->addJoin(MessagePeer::ID, MessageRecipientPeer::MESSAGE_ID, Criteria::LEFT_JOIN);
            $c->add(MessageRecipientPeer::RECIPIENT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
            $c->add(MessageRecipientPeer::RECIPIENT_ID, $this->id);
            $c->add(MessageRecipientPeer::FOLDER_ID, MessagePeer::MFOLDER_INBOX);
            $c->add(MessageRecipientPeer::DELETED_AT, null, Criteria::ISNULL);
            $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
            $this->aReceivedMessages = MessagePeer::doSelect($c);
        }
        return $this->aReceivedMessages;
    }
    
    public function getUnreadMessageCount()
    {
        $con = Propel::getConnection();
        
        $sql = "SELECT count(*) FROM ".MessageRecipientPeer::TABLE_NAME."
                WHERE ".MessageRecipientPeer::IS_READ."=0 AND
                      ".MessageRecipientPeer::RECIPIENT_ID."=".$this->getId()." AND
                      ".MessageRecipientPeer::RECIPIENT_TYPE_ID."=".PrivacyNodeTypePeer::PR_NTYP_COMPANY." AND
                      ".MessageRecipientPeer::FOLDER_ID."=".MessagePeer::MFOLDER_INBOX." AND
                      ".MessageRecipientPeer::DELETED_AT." IS NULL
                ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $rs = $stmt->fetch(PDO::FETCH_NUM);
        return $rs[0];
    }
    
    public function getSentMessages()
    {
        if (is_null($this->aSentMessages))
        {
            $c = new Criteria();
            $c->add(MessagePeer::SENDER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
            $c->add(MessagePeer::SENDER_ID, $this->id);
            $c->add(MessagePeer::DELETED_AT, null, Criteria::ISNULL);
            $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
            $this->aSentMessages = MessagePeer::doSelect($c);
        }
        return $this->aSentMessages;
    }
    
    public function getArchivedMessages()
    {
        if (is_null($this->aArchivedMessages))
        {
            $c = new Criteria();
            $c->addJoin(MessagePeer::ID, MessageRecipientPeer::MESSAGE_ID, Criteria::LEFT_JOIN);
            $c->add(MessageRecipientPeer::RECIPIENT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
            $c->add(MessageRecipientPeer::RECIPIENT_ID, $this->id);
            $c->add(MessageRecipientPeer::FOLDER_ID, MessagePeer::MFOLDER_ARCHIVED);
            $c->add(MessageRecipientPeer::DELETED_AT, null, Criteria::ISNULL);
            $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
            $this->aReceivedMessages = MessagePeer::doSelect($c);
        }
        return $this->aReceivedMessages;
    }
    
    public function getProductCategories($c1=null)
    {
        if ($c1)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        $c->addJoin(ProductCategoryPeer::ID, ProductPeer::CATEGORY_ID);
        $c->add(ProductPeer::COMPANY_ID, $this->getId());
        $c->setDistinct();
        $c->addAscendingOrderByColumn(ProductCategoryI18nPeer::NAME);
        return ProductCategoryPeer::doSelectWithI18n($c);
    }
    
    public function getProductCategory($id)
    {
        if ($id && is_numeric($id))
        {
            $c = new Criteria();
            $c->add(ProductCategoryPeer::ID, $id);
            $cat = $this->getProductCategories($c);
            if (count($cat)) return $cat[0];
            else return null;
        }
        else
        {
            return null;
        }
    }
    
    public function getProductsOfCategory($id)
    {
        $c = new Criteria();
        $c->add(ProductPeer::CATEGORY_ID, $id);
        $c->add(ProductPeer::ACTIVE, 1);
        return $this->getProducts($c);
    }
    
    public function getProduct($id)
    {
        $c = new Criteria();
        $c->add(ProductPeer::ID, $id);
        $product = $this->getProducts($c);
        return (is_array($product) && count($product)) ? $product[0] : null;
    }
    
    public function getB2bLead($id)
    {
        $c = new Criteria();
        $c->add(B2bLeadPeer::ID, $id);
        $lead = $this->getB2bLeads($c);
        return (is_array($lead) && count($lead)) ? $lead[0] : null;
    }
    
    public function getMediaItems($c1 = null)
    {
        if (is_int($c1))
        {
            return MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, $c1);
        }
        
        if ($c1)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        
        return MediaItemPeer::doSelect($c);
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
        
        $c->add(MediaItemPeer::OWNER_ID, $this->getId() ? $this->getId() : 0);
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->add(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_ALBUM_PHOTO);
        return $count ? MediaItemPeer::doCount($c) : MediaItemPeer::doSelect($c);
    }
    
    public function getProductPhotos()
    {
        $c = new Criteria();
        $c->addJoin(CompanyPeer::ID, ProductPeer::COMPANY_ID);
        $c->add(CompanyPeer::ID, $this->getId());
        $c->addJoin(ProductPeer::ID, MediaItemPeer::OWNER_ID);
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_PRODUCT);
        return MediaItemPeer::doSelect($c);
    }
        
    public function getPhoto($mi_id)
    {
        $item = MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, MediaItemPeer::MI_TYP_ALBUM_PHOTO, $mi_id);
        if (count($item))
            return $item[0];
        else
            return null;
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
        if ($oldlogo)
        {
            $oldlogo->setItemTypeId(MediaItemPeer::MI_TYP_ALBUM_PHOTO);
            $oldlogo->save();
        }
        $mediaitem->setItemTypeId(MediaItemPeer::MI_TYP_LOGO);
        $mediaitem->save();
        return true;
    }
    
    public function getTotalUsedStorage()
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        $c->clearSelectColumns();
        $c->addAsColumn('TOTALSIZE', "sum(".MediaItemPeer::FILE_SIZE.")");
        
        $res = BasePeer::doSelect($c);
        $res->execute();
        $value = $res->fetch(PDO::FETCH_ASSOC);
        return $value['TOTALSIZE']?$value['TOTALSIZE']:0;
    }
    
    public function getAvailableStorage()
    {
        return 100*1024*1024;
    }
    
    public function getVideos()
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_VIDEO);
        return $this->getMediaItems($c);
    }
    
    /**
     * Get the Contact object if available.
     * 
     * @return     Contact
     */
    public function getContact()
    {
        $prof = $this->getCompanyProfile();
        if ($prof) return $prof->getContact();
        else return null;
    }

    public function getRequests()
    {
        $c = new Criteria();
        $c->add(RelationPeer::STATUS, RelationPeer::RL_STAT_PENDING_CONFIRMATION);
        return $this->getRelationsRelatedByRelatedCompanyId($c);
    }
    
    public function getRequestCount()
    {
        $c = new Criteria();
        $c->add(RelationPeer::STATUS, RelationPeer::RL_STAT_PENDING_CONFIRMATION);
        return $this->countRelationsRelatedByRelatedCompanyId($c);
    }
    
    public function getActions()
    {
        $c = new Criteria();
        $c->add(ActionLogPeer::OBJECT_ID, $this->getId());
        $c->add(ActionLogPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->addAscendingOrderByColumn(ActionLogPeer::CREATED_AT);
        return ActionLogPeer::doSelect($c);
    }
    
    public function getActiveProducts()
    {
        $c = new Criteria();
        $c->add(ProductPeer::ACTIVE, 1);
        return $this->getProducts($c);
    }

    public function countActiveProducts()
    {
        $c = new Criteria();
        $c->add(ProductPeer::ACTIVE, 1);
        return $this->countProducts($c);
    }
    
    public function getHRProfile()
    {
        $c = new Criteria();
        $c->add(HRProfilePeer::OWNER_ID, $this->getId());
        $c->add(HRProfilePeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        return HRProfilePeer::doSelectOne($c);
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
        $c->add(JobPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
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
        $c->add(JobPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
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
        $c->add(PurchasePeer::BUYER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
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
    
    public function can($action_id, $object=null, $object_type_id = null)
    {
        $type_array = array('User' => 1,
                            'Company' => 2,
                            'Group' => 3);

        if (isset($object) && is_object($object))
        {
            $object_id = $object->getId();
            $object_type_id = $type_array[get_class($object)];
        }
        else
        {
            $object_id = $object;
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
        ((ROOT_ID={$this->getId()} AND ROOT_TYPE_ID=2) OR (ROOT_ID IS NULL))
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
    
    public function isMemberOf($group_id, $role_id = null, $status = null)
    {
        $c = new Criteria();
        $c->add(GroupMembershipPeer::OBJECT_ID, $this->getId());
        $c->add(GroupMembershipPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->add(GroupMembershipPeer::GROUP_ID, $group_id);
        if ($role_id) $c->add(GroupMembershipPeer::ROLE_ID, $role_id);
        $c->add(GroupMembershipPeer::STATUS, isset($status) ? $status : GroupMembershipPeer::STYP_ACTIVE);
        $c->addDescendingOrderByColumn(GroupMembershipPeer::CREATED_AT);
        return GroupMembershipPeer::doSelectOne($c);
    }

    public function getGroupMembership($group_id)
    {
        $c = new Criteria();
        $c->addJoin(GroupPeer::ID, GroupMembershipPeer::GROUP_ID, Criteria::INNER_JOIN);
        $c->add(GroupMembershipPeer::OBJECT_ID, $this->getId());
        $c->add(GroupMembershipPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->add(GroupMembershipPeer::STATUS, GroupMembershipPeer::STYP_ACTIVE);
        $c->add(GroupPeer::ID, $group_id);
        return GroupMembershipPeer::doSelectOne($c);
    }
    
    public function getGroupMemberships($role_id = null, $status = null, $get_groups = false)
    {
        $wheres = array_filter(
                    array($role_id ? "RLS.ID=$role_id" : null,
                        $status ? "EMT_GROUP_MEMBERSHIP_VIEW.STATUS=$status" : null,
                        )
                    );
        $con = Propel::getConnection();
        $sql = "SELECT * FROM EMT_GROUP_MEMBERSHIP_VIEW "
              .( $role_id ? "LEFT JOIN
                (
                    SELECT CONNECT_BY_ROOT ID SPOINT, ID, SYSNAME, LEVEL LVL FROM EMT_ROLE
                    START WITH PARENT_ID IS NOT NULL
                    CONNECT BY NOCYCLE PRIOR PARENT_ID = ID
                ) RLS ON EMT_GROUP_MEMBERSHIP_VIEW.ROLE_ID=RLS.SPOINT": "")."        
                WHERE OBJECT_ID={$this->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY
              .(count($wheres) ? " AND ".implode(' AND ', $wheres) : "");
        if ($get_groups)
        {
            $sql = "SELECT EMT_GROUP.* FROM
                    ($sql) GMX
                    LEFT JOIN EMT_GROUP ON GMX.GROUP_ID=EMT_GROUP.ID";
        }
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $get_groups ? GroupPeer::populateObjects($stmt) : GroupMembershipPeer::populateObjects($stmt);
    }

    public function getAdjective()
    {
        return 'its';
    }

    public function getOwner()
    {
        $c = new Criteria();
        $c->addJoin(CompanyPeer::ID, CompanyUserPeer::COMPANY_ID, Criteria::LEFT_JOIN);
        $c->addJoin(CompanyUserPeer::OBJECT_ID, UserPeer::ID, Criteria::LEFT_JOIN);
        $c->add(CompanyUserPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(CompanyPeer::ID, $this->getId());
        $c->add(CompanyUserPeer::ROLE_ID, RolePeer::RL_CM_OWNER);
        return UserPeer::doSelectOne($c);
    }
    
    public function getPhotosUrl($paramstr = null)
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "b2b")
            return "@company-photos?hash=".$this->getHash().(isset($paramstr) ? "&$paramstr" : "");
        else
            return "@b2b.company-photos?hash=".$this->getHash().(isset($paramstr) ? "&$paramstr" : "");
    }
    
    public function getProductsUrl($paramstr = null)
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "b2b")
            return "@company-products?hash=".$this->getHash().(isset($paramstr) ? "&$paramstr" : "");
        else
            return "@b2b.company-products?hash=".$this->getHash().(isset($paramstr) ? "&$paramstr" : "");
    }
    
    public function getProductUrl($product_id)
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "b2b")
            return "@product-detail?hash={$this->getHash()}&id={$product_id}";
        else
            return "@b2b.product-detail?hash={$this->getHash()}&id={$product_id}";
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
    
        $result = $i18n->__("a company");
        
        $result = $is_owner ? $i18n->__("your company %1c", array('%1c' => $this)) : $i18n->__("%1u's company %2c", array('%1u' => $top_owner, '%2c' => $this));

        if ($target_culture) $i18n->setCulture($cl);
        return $result;
    }
    
    public function getLeads($c1 = null, $type_id = null, $count = false, $filter_inactive = false)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria;
        }
        if (isset($type_id)) $c->add(B2bLeadPeer::TYPE_ID, $type_id);
        
        if ($filter_inactive)
        {
            $c->add(B2bLeadPeer::ACTIVE, 1);
            $c->add(B2bLeadPeer::EXPIRES_AT, 'TRUNC(EMT_B2B_LEAD.EXPIRES_AT) >= TRUNC(SYSDATE)', Criteria::CUSTOM);
        }
        
        return $count ? $this->countB2bLeads($c) : $this->getB2bLeads($c);
    }
        
    public function getBuyingLeads($c1 = null, $count = false, $filter_inactive = false)
    {
        return $this->getLeads($c1, B2bLeadPeer::B2B_LEAD_BUYING, $count, $filter_inactive);
    }
        
    public function countBuyingLeads($c1 = null, $filter_inactive = false)
    {
        return $this->getBuyingLeads($c1, true, $filter_inactive);
    }
        
    public function getSellingLeads($c1 = null, $count = false, $filter_inactive = false)
    {
        return $this->getLeads($c1, B2bLeadPeer::B2B_LEAD_SELLING, $count, $filter_inactive);
    }
        
    public function countSellingLeads($c1 = null, $filter_inactive = false)
    {
        return $this->getSellingLeads($c1, true, $filter_inactive);
    }
        
    public function getManageUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . "company-manage?hash={$this->getHash()}";  
    }
    
    public function getOrderedBrands($for_select = false)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(CompanyBrandPeer::NAME);
        $brds = $this->getCompanyBrands($c);
        
        if ($for_select) {
            $prs = array();
            foreach ($brds as $brd) {
                $prs[$brd->getId()] = $brd->getName();
            }
            return $prs;
        }
        else {
            return $brds;
        }
    }

    public function getBrandById($bid)
    {
        $c = new Criteria();
        $c->add(CompanyBrandPeer::ID, $bid);
        $brands = $this->getCompanyBrands($c);
        return count($brands) ? $brands[0] : null;
    }
    
    public function getOrderedCategories($for_select = false)
    {
        $con = Propel::getConnection();
        
        $sql = "
        SELECT DISTINCT EMT_PRODUCT_CATEGORY.* FROM
        (
            SELECT EMT_PRODUCT_CATEGORY_I18N.* FROM EMT_PRODUCT_CATEGORY_I18N
            LEFT JOIN EMT_PRODUCT_CATEGORY ON EMT_PRODUCT_CATEGORY_I18N.ID=EMT_PRODUCT_CATEGORY.ID
            LEFT JOIN EMT_PRODUCT ON EMT_PRODUCT_CATEGORY.ID=EMT_PRODUCT.CATEGORY_ID
            WHERE COMPANY_ID={$this->getId()}
            ORDER BY ".myTools::NLSFunc(ProductCategoryI18nPeer::NAME, 'SORT')."
        ) GRP
        LEFT JOIN EMT_PRODUCT_CATEGORY ON GRP.ID=EMT_PRODUCT_CATEGORY.ID
        ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        $brds = ProductCategoryPeer::populateObjects($stmt);
        
        if ($for_select) {
            $prs = array();
            foreach ($brds as $brd) {
                $prs[$brd->getId()] = $brd->getName();
            }
            return $prs;
        }
        else {
            return $brds;
        }
    }
    
    public function getOrderedGroups($for_select = false)
    {
        $con = Propel::getConnection();
        
        $sql = "
        SELECT DISTINCT EMT_PRODUCT_GROUP.* FROM
        (
            SELECT EMT_PRODUCT_GROUP_I18N.* FROM EMT_PRODUCT_GROUP_I18N
            LEFT JOIN EMT_PRODUCT_GROUP ON EMT_PRODUCT_GROUP_I18N.ID=EMT_PRODUCT_GROUP.ID
            WHERE COMPANY_ID={$this->getId()}
            ORDER BY ".myTools::NLSFunc(ProductGroupI18nPeer::NAME, 'SORT')."
        ) GRP
        LEFT JOIN EMT_PRODUCT_GROUP ON GRP.ID=EMT_PRODUCT_GROUP.ID
        ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        $brds = ProductGroupPeer::populateObjects($stmt);
        
        if ($for_select) {
            $prs = array();
            foreach ($brds as $brd) {
                $prs[$brd->getId()] = $brd->getName();
            }
            return $prs;
        }
        else {
            return $brds;
        }
    }
    
    public function getProductGroupById($gid)
    {
        $c = new Criteria();
        $c->add(ProductGroupPeer::ID, $gid);
        $grps = $this->getProductGroups($c);
        return count($grps) ? $grps[0] : null;
    }
    
    public function getProductGroupByStrippedName($stripped_name)
    {
        $c = new Criteria();
        $c->addJoin(ProductGroupPeer::ID, ProductGroupI18nPeer::ID, Criteria::INNER_JOIN);
        $c->add(ProductGroupI18nPeer::STRIPPED_NAME, $stripped_name);
        $grps = $this->getProductGroups($c);
        return count($grps) ? $grps[0] : null;
    }
    
    public function getProductsByApprovalStatus($status = null)
    {
        if (isset($status))
        {
            $c = new Criteria();
            if (is_array($status)) $c->add(ProductPeer::APPROVAL_STATUS, $status, Criteria::IN);
            else $c->add(ProductPeer::APPROVAL_STATUS, $status);
            return $this->getProducts($c);
        }

        $prods = $this->getProducts();
        
        $prodArray = array(ProductPeer::PR_STAT_APPROVED => array(),
                           ProductPeer::PR_STAT_EDITING_REQUIRED => array(),
                           ProductPeer::PR_STAT_PENDING_APPROVAL => array()
                       );
        
        foreach ($prods as $prod)
        {
            $prodArray[$prod->getApprovalStatus()][] = $prod;
        }
        return $prodArray;
    }
    
    public function getProductPager($page, $items_per_page = 20, $c1 = null, $status = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        if (isset($status)) $c->add(ProductPeer::APPROVAL_STATUS, $status);
        $c->add(ProductPeer::COMPANY_ID, $this->getId());
        
        $pager = new sfPropelPager('Product', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }

    public function getLeadPager($page, $items_per_page = 20, $c1 = null, $type = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        if (isset($type)) $c->add(B2bLeadPeer::TYPE_ID, $type);
        $c->add(B2bLeadPeer::COMPANY_ID, $this->getId());
        
        $pager = new sfPropelPager('B2bLead', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
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
        $c->add(JobPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        
        $pager = new sfPropelPager('Job', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
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
        $c->add(EventPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        
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
        $c->add(EventPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);

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
        $stmt->bindValue(':OWNER_TYPE_ID', PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $stmt->bindValue(':OWNER_ID', $this->getId());
        $stmt->execute();
        
        return $count ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : EventPeer::populateObjects($stmt);
    }
    
    public function countEventsByPeriod($p_const_id)
    {
        return $this->getEventsByPeriod($p_const_id, true);
    }
    
    public function getOwnerLastLoginDate($format = null)
    {
        return $this->getOwner()->getLastLoginDate($format);
    }
    
    public function getTransferProcess($status_id, $return_single = true)
    {
        $status_id = is_array($status_id) ? $status_id : array($status_id);
        $c = new Criteria();
        $c->add(TransferOwnershipRequestPeer::ACCOUNT_ID, $this->getId());
        $c->add(TransferOwnershipRequestPeer::ACCOUNT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->add(TransferOwnershipRequestPeer::STATUS, $status_id, Criteria::IN);
        $c->addDescendingOrderByColumn(TransferOwnershipRequestPeer::CREATED_AT);
        return $return_single ? TransferOwnershipRequestPeer::doSelectOne($c) : TransferOwnershipRequestPeer::doSelect($c);
    }
    
    public function getCompanyUserFor($object_id = null, $object_type_id = null, $role_id = null, $status = null)
    {
        if (!(($object_id && $object_type_id) || $role_id)) return null;
        
        $statuscr = isset($status) && !is_array($status) ? array($status) : $status;
        
        $con = Propel::getConnection();
        
        if ($object_type_id == PrivacyNodeTypePeer::PR_NTYP_COMPANY)
        {
            $filter = array(CompanyUserPeer::CU_STAT_ENDED_BY_STARTER_USER,
                            CompanyUserPeer::CU_STAT_ENDED_BY_TARGET_USER,
                            CompanyUserPeer::CU_STAT_REJECTED);

            $sql = "SELECT * FROM EMT_COMPANY_USER_VIEW
                    LEFT JOIN EMT_ROLE ON ROLE_ID=EMT_ROLE.ID
                    WHERE OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY." AND (COMPANY_ID={$this->getId()} AND OBJECT_ID=$object_id" . ($role_id ? " AND ROLE_ID=$role_id" : "") . ") OR ($object_type_id=".PrivacyNodeTypePeer::PR_NTYP_COMPANY." AND COMPANY_ID=$object_id AND OBJECT_ID={$this->getId()}" . ($role_id ? " AND EMT_ROLE.OPPOSITE_ROLE_ID=$role_id" : "") . ")
                    AND " . (isset($status) ? "STATUS IN (" . implode(',', $statuscr) . ")" : " STATUS NOT IN (" . implode(',',$filter) . ")");
            
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $rr = CompanyUserPeer::populateObjects($stmt);
            return count($rr) ? $rr[0] : null;
            
        }
        
        $sql = "SELECT * FROM EMT_COMPANY_USER_VIEW
                WHERE COMPANY_ID={$this->getId()} AND OBJECT_TYPE_ID!=".PrivacyNodeTypePeer::PR_NTYP_COMPANY
                .(isset($object_id) ? " AND OBJECT_ID=$object_id AND OBJECT_TYPE_ID=$object_type_id" : "")
                .(isset($role_id) ? " AND ROLE_ID=$role_id" : "")
                .(isset($status) ? " AND STATUS_ID IN (".implode(',', $statuscr).")" : "");
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $cus = CompanyUserPeer::populateObjects($stmt);
        
        return isset($object_id) && count($cus) ? $cus[0] : $cus;
    }

    public function getActivityLevelInGroup($group_id)
    {
        // this function should evaluate the users group activity and return a numeric value
        return 0.5;
    }
    
    public function getTopProducts($num = null) 
    {
        $c = new Criteria();
        $c->add(ProductPeer::IS_TOP_PRODUCT, 1);
        $c->add(ProductPeer::ACTIVE, 1);
        if (isset($num)) $c->setLimit($num);
        return $this->getProducts($c);
    }
    
    public function getStatusUpdates()
    {
        $c = new Criteria();
        $c->add(StatusUpdatePeer::OBJECT_ID, $this->getId());
        $c->add(StatusUpdatePeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->addDescendingOrderByColumn(StatusUpdatePeer::CREATED_AT);
        return StatusUpdatePeer::doSelect($c);
    }
    
    public function getConnections($type_id = null, $role_id = null, $role_hierarchy = true, $return_objects = true, $row_num = 20, $shuffle = false, $ipp = 0, $page = null, $criterias = array(), $get_asset_type = null, $count = false)
    {
        if (!isset($criterias['wheres'])) $criterias['wheres'] = array();
        if (!isset($criterias['joins'])) $criterias['joins'] = array();

        $subject_id = $this->isNew() ? 0 : $this->getId();
        $subject_type_id = PrivacyNodeTypePeer::PR_NTYP_COMPANY;
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

    public function getLocationLabel($type = ContactPeer::WORK)
    {
        $adr = ($cnt = $this->getContact()) ? $cnt->getAddressByType($type) : null;
        return $adr ? implode(', ', array_filter(array($adr->getGeonameCity(), CountryPeer::retrieveByISO($adr->getCountry())))) : null;
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
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->addDescendingOrderByColumn(MediaItemPeer::CREATED_AT);
        
        $pager = new sfPropelPager('MediaItem', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }

    public function createFolder($name, $type)
    {
        try
        {
            $f = new MediaItemFolder();
            $f->setName($name);
            $f->setOwnerId($this->id);
            $f->setOwnerTypeId(PrivacyNodeTypePeer::PR_NTYP_COMPANY);
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
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->add(MediaItemFolderPeer::OWNER_ID, $this->id);
        if (isset($type)) $c->add(MediaItemFolderPeer::TYPE_ID, $type);
        return MediaItemFolderPeer::doSelect($c);
    }
    
    public function getFolder($id, $type=null)
    {
        $c = new Criteria();
        $c->add(MediaItemFolderPeer::ID, $id);
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->add(MediaItemFolderPeer::OWNER_ID, $this->id);
        if (isset($type)) $c->add(MediaItemFolderPeer::TYPE_ID, $type);
        return MediaItemFolderPeer::doSelectOne($c);
    }
    
    public function getFolderByName($name, $type=null)
    {
        $c = new Criteria();
        $c->add(MediaItemFolderPeer::NAME, $name);
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
        $c->add(MediaItemFolderPeer::OWNER_ID, $this->id);
        if (isset($type)) $c->add(MediaItemFolderPeer::TYPE_ID, $type);
        return MediaItemFolderPeer::doSelectOne($c);
    }
    
    public function getFolderByType($type)
    {
        $c = new Criteria();
        $c->add(MediaItemFolderPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
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
    
    public function isOnline()
    {
        return ($this->getAvailable() && !$this->getBlocked() && !$this->getOwner()->isBlocked());
    }

    public function getStatusCode()
    {
        if ($this->getBlocked()) {
            return CompanyPeer::CMP_STAT_IS_SUSPENDED;
        }
        elseif (!$this->getAvailable()) {
            return CompanyPeer::CMP_STAT_IS_UNPUBLISHED;
        }
        elseif ($this->getOwner()->isBlocked()) {
            return CompanyPeer::CMP_STAT_OWNER_BLOCKED;
        }
        else {
            return CompanyPeer::CMP_STAT_ONLINE;
        }
    }
    
    public function getStatusMessage()
    {
        return CompanyPeer::$statMessages[$this->getStatusCode()];
    }

    public function getPremiumAccount($type_id = null)
    {
        return PremiumAccountPeer::getAccountFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, $type_id);
    }

    public function getMessageFolders()
    {
        return $this->getFolders(MediaItemFolderPeer::MIF_TYP_MESSAGE);
    }
}