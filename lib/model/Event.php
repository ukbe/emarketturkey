<?php

class Event extends BaseEvent
{
    private $hash = null;

    public function __toString()
    {
        return $this->getName() ? $this->getName() : $this->getDefaultName();
    }

    public function getDefaultName()
    {
        return $this->getName($this->getDefaultLang());
    }
    
    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_EVENT;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_EVENT) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getUrl($load_app = null)
    {
        $app = sfContext::getInstance()->getConfiguration()->getApplication();
        
        switch ($this->getEventType()->getTypeClass())
        {
            case EventTypePeer::ECLS_TYP_BUSINESS :
                return ($app == 'camp' ? "@tradeshow-detail?guid={$this->getGuid()}" : "@camp.tradeshow-detail?guid={$this->getGuid()}");
            case EventTypePeer::ECLS_TYP_ACADEMIC :
                return ($app == 'camp' ? "@event-detail?guid={$this->getGuid()}" : "@camp.event-detail?guid={$this->getGuid()}");
            case EventTypePeer::ECLS_TYP_SOCIAL :
                return ($app == 'camp' ? "@event-detail?guid={$this->getGuid()}" : "@camp.event-detail?guid={$this->getGuid()}");
        }
        return (!$load_app || $load_app == $app ? '@' : "@$load_app.") . $route;
    }

    public function getManageUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . ($this->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "company-event-action?action=details&hash={$this->getOwner()->getHash()}&id={$this->getId()}" : "group-event-action?action=details&hash={$this->getOwner()->getHash()}&id={$this->getId()}");  
    }

    public function getEditUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . ($this->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "company-event-action?action=add&hash={$this->getOwner()->getHash()}&id={$this->getId()}" : "group-event-action?action=add&hash={$this->getOwner()->getHash()}&id={$this->getId()}");  
    }

    public function getOwner()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getOwnerId(), $this->getOwnerTypeId());
    }

    public function getPlaceText()
    {
        return $this->getPlace() ? $this->getPlace()->getLongName() : implode(', ', array_filter(array($this->getLocationName(), $this->getGeonameCity(), CountryPeer::retrieveByISO($this->getLocationCountry()))));
    }

    public function getLocationText()
    {
        return !$this->getPlace() ? implode(', ', array_filter(array($this->getGeonameCity(), CountryPeer::retrieveByISO($this->getLocationCountry())))) : '';
    }

    public function getOrganiserText()
    {
        return $this->getOrganiser() ? $this->getOrganiser() : $this->getOrganiserName();
    }

    public function getLogo()
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_LOGO);
        $logo_ar = $this->getMediaItems($c);
        return count($logo_ar) ? $logo_ar[0] : null;
    }

    public function getBanner()
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_BANNER_IMAGE);
        $banner_ar = $this->getMediaItems($c);
        return count($banner_ar) ? $logo_ar[0] : null;
    }
    
    public function getLogoUri($size = MediaItemPeer::LOGO_TYP_SMALL)
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

    public function getPhotoById($id_or_guid)
    {
        $item = MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_EVENT, null, $id_or_guid);
        return count($item) ? $item[0] : null;
    }
    
    public function getPhotos($limit=null, $folder_id=null)
    {
        $c = new Criteria();
        if (is_int($limit)) $c->setLimit($limit);
        if (is_int($limit)) $c->setLimit($limit);
        
        $photos = $this->getMediaItems($c);
        if ($limit === 1 && count($photos))
            return $photos[0];
        else
            return $photos;
    }
    
    public function getMediaItems($c1 = null)
    {
        if (is_int($c1))
        {
            return MediaItemPeer::retrieveItemsFor($this->getId() ? $this->getId() : 0, PrivacyNodeTypePeer::PR_NTYP_EVENT, $c1);
        }
        
        if ($c1)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_EVENT);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        
        return MediaItemPeer::doSelect($c);
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
            
            $sql = "SELECT CULTURE FROM EMT_EVENT_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(EventI18nPeer::ID, $this->getId());
        $c->add(EventI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return EventI18nPeer::doDelete($c);
    }
    
    public function getOrganiser()
    {
        if ($this->getOrganiserId() && $this->getOrganiserTypeId())
            return PrivacyNodeTypePeer::retrieveObject($this->getOrganiserId(), $this->getOrganiserTypeId());
    }
    
    public function getInviteFor($obj_id, $obj_type_id)
    {
        $c = new Criteria();
        $c->add(EventInvitePeer::SUBJECT_ID, $obj_id);
        $c->add(EventInvitePeer::SUBJECT_TYPE_ID, $obj_type_id);
        $invs = $this->getEventInvites($c);
        return count($invs) ? $invs[0] : null;
    }
    
    public function getAttenders($type_id = null, $count = false, $status = null, $rand = false)
    {
        $con = Propel::getConnection();
        
        $sqls = array(
            PrivacyNodeTypePeer::PR_NTYP_USER => "
                SELECT " . ($count ? "COUNT(EMT_USER.*)" : "EMT_USER.*") . " FROM EMT_EVENT_INVITE
                LEFT JOIN EMT_USER ON EMT_EVENT_INVITE.SUBJECT_ID=EMT_USER.ID
                WHERE EMT_EVENT_INVITE.EVENT_ID={$this->getId()} AND EMT_EVENT_INVITE.SUBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER
                .(isset($status) ? " AND EMT_EVENT_INVITE.RSVP_STATUS=$status" : "")
                .(!$count ? " ORDER BY " . ($rand ? "dbms_random.value" : "NLSSORT(NAME,'NLS_SORT=GENERIC_M_CI'), NLSSORT(LASTNAME,'NLS_SORT=GENERIC_M_CI')") : ""),
            PrivacyNodeTypePeer::PR_NTYP_COMPANY => "
                SELECT " . ($count ? "COUNT(EMT_COMPANY.*)" : "EMT_COMPANY.*") . " FROM EMT_EVENT_INVITE
                LEFT JOIN EMT_COMPANY ON EMT_EVENT_INVITE.SUBJECT_ID=EMT_COMPANY.ID
                WHERE EMT_EVENT_INVITE.EVENT_ID={$this->getId()} AND EMT_EVENT_INVITE.SUBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY
                .(isset($status) ? " AND EMT_EVENT_INVITE.RSVP_STATUS=$status" : "")
                .(!$count ? " ORDER BY " . ($rand ? "dbms_random.value" : "NLSSORT(NAME,'NLS_SORT=GENERIC_M_CI')") : ""),
            PrivacyNodeTypePeer::PR_NTYP_GROUP => "
                SELECT " . ($count ? "COUNT(EMT_GROUP.*)" : "EMT_GROUP.*") . " FROM EMT_EVENT_INVITE
                LEFT JOIN EMT_GROUP ON EMT_EVENT_INVITE.SUBJECT_ID=EMT_GROUP.ID
                WHERE EMT_EVENT_INVITE.EVENT_ID={$this->getId()}AND EMT_EVENT_INVITE.SUBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_GROUP
                .(isset($status) ? " AND EMT_EVENT_INVITE.RSVP_STATUS=$status" : "")
                .(!$count ? " ORDER BY " . ($rand ? "dbms_random.value" : "NLSSORT(NAME,'NLS_SORT=GENERIC_M_CI')") : "")
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
                    case PrivacyNodeTypePeer::PR_NTYP_GROUP : $atts[$type] = GroupPeer::populateObjects($stmt);
                        break;
                }
            }
        }
        
        return $type_id ? $atts[$type_id] : $atts;
    }
    
    public function getRelatedAttenders($type_id = null)
    {
        
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
    
        $result = $i18n->__("an event");
        
        $result = $is_owner ? $i18n->__("your event %1c", array('%1c' => $this)) : $i18n->__("%1u's event %2c", array('%1u' => $top_owner, '%2c' => $owner));

        if ($target_culture) $i18n->setCulture($cl);
        return $result;
    }
    
    public function getPhotosUrl($paramstr = null)
    {
        return $this->getUrl() . (isset($paramstr) ? "&$paramstr" : "");
    }

}
