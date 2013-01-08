<?php

class Place extends BasePlace
{
    protected $o_owner = null;
    private $hash = null;
    
    public function __toString()
    {
        return $this->getName() ? $this->getName() : $this->getDefaultName();
    }

    public function getLongName()
    {
        return implode(', ', array_filter(array($this->getName(), $this->getLocationText())));
    }

    public function getLocationText()
    {
        return implode(', ', array_filter(array($this->getGeonameCity(), CountryPeer::retrieveByISO($this->getCountry()))));
    }
    
    public function getDefaultName()
    {
        return $this->getName($this->getDefaultLang());
    }
    
    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_PLACE;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_PLACE) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getUrl()
    {
        return (sfContext::getInstance()->getConfiguration()->getApplication() == "camp" ? "@" : "@camp.") . "place-profile?hash=".$this->getHash();
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
    
    public function getMediaItems($c1 = null)
    {
        if (is_int($c1))
        {
            return MediaItemPeer::retrieveItemsFor($this->getId() ? $this->getId() : 0, PrivacyNodeTypePeer::PR_NTYP_PLACE, $c1);
        }
        
        if ($c1)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_PLACE);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        
        return MediaItemPeer::doSelect($c);
    }
    
    public function getOwner()
    {
        return isset($this->o_owner) ? $this->o_owner : ($this->o_owner = PrivacyNodeTypePeer::retrieveObject($this->getOwnerId(), $this->getOwnerTypeId()));
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
        
        $c->add(EventPeer::PLACE_ID_, $this->getId());
        
        $pager = new sfPropelPager('Event', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }

    public function getEventsByPeriod($p_const_id, $count = false)
    {
        $con = Propel::getConnection();

        $sql = str_replace('OWNER_TYPE_ID=:OWNER_TYPE_ID AND OWNER_ID=:OWNER_ID', 'PLACE_ID=:PLACE_ID', EventPeer::$sqls[$p_const_id]);
        
        if ($count)
        {
            $sql = "
                SELECT COUNT(*) FROM ($sql)
            ";
        }
        
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':PLACE_ID', $this->getId());
        $stmt->execute();
        
        return $count ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : EventPeer::populateObjects($stmt);
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
    
        $result = $i18n->__("an event venue");
        
        $result = $is_owner ? $i18n->__("your venue %1c", array('%1c' => $this)) : $i18n->__("%1u's venue %2c", array('%1u' => $top_owner, '%2c' => $owner));

        if ($target_culture) $i18n->setCulture($cl);
        return $result;
    }
    
    public function getPhotosUrl($paramstr = null)
    {
        return $this->getUrl() . (isset($paramstr) ? "&$paramstr" : "");
    }

}
