<?php

class TradeExpert extends BaseTradeExpert
{
    protected $o_holder = null;
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
        return PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getClob($field, $culture = null)
    {
        $conf = Propel::getConfiguration();
        $conf = $conf['datasources'][$conf['datasources']['default']]['connection'];
        
        if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
        if (!($c = @oci_connect($conf['user'], $conf['password'], $conf['database'])))
        {echo "no connection";}
        
        $sql = "SELECT $field 
                FROM EMT_TRADE_EXPERT_I18N 
                WHERE ID={$this->getId()} AND CULTURE='$culture'";
        $stmt = oci_parse($c, $sql);
        oci_execute($stmt);
        $res = oci_fetch_row($stmt);
        return isset($res[0]) ? $res[0]->load() : "";
    }
    
    public function getHolder()
    {
        return isset($this->o_holder) ? $this->o_holder : ($this->o_holder = PrivacyNodeTypePeer::retrieveObject($this->getHolderId(), $this->getHolderTypeId()));
    }
    
    public function getProfilePictureUri($size = MediaItemPeer::LOGO_TYP_SMALL)
    {
        return $this->getHolder()->getProfilePictureUri($size);
    }
    
    public function getProfileUrl()
    {
        return (sfContext::getInstance()->getConfiguration()->getApplication() == "b2b" ? "@" : "@b2b.") . "tradeexpert-profile?hash=".$this->getHash();
    }

    public function getContact()
    {
        return $this->getHolder()->getContact();
    }
    
    public function getIndustries()
    {
        $c = new Criteria();
        $c->addJoin(TradeExpertIndustryPeer::INDUSTRY_ID, BusinessSectorPeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(BusinessSectorPeer::ID, BusinessSectorI18nPeer::ID, Criteria::LEFT_JOIN);
        $c->add(TradeExpertIndustryPeer::ID, $this->getId());
        $c->add(BusinessSectorI18nPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());
        $c->addAscendingOrderByColumn(myTools::NLSFunc(BusinessSectorI18nPeer::NAME, 'SORT'));
        return BusinessSectorPeer::doSelect($c);
    }
    
    public function getIndustriesText()
    {
        return implode(', ', $this->getIndustries());
    }

    public function getAreas()
    {
        $c = new Criteria();
        $c->add(TradeExpertAreaPeer::ID, $this->getId());
        
        return TradeExpertAreaPeer::doSelect($c);
    }
    
    public function getAreasText()
    {
        return implode(', ', $this->getAreas());
    }
    
    public function getProfilePicture()
    {
        return $this->getHolder()->getProfilePicture();
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
    
        $result = $i18n->__("a Trade Expert");
        
        $result = $is_owner ? $i18n->__("your Trade Expert profile %1c", array('%1c' => $this)) : $i18n->__("%1u's Trade Expert profile %2c", array('%1u' => $top_owner, '%2c' => $owner));

        if ($target_culture) $i18n->setCulture($cl);
        return $result;
    }
    
    public function getOwner()
    {
        return $this->getHolder();
    }
    
    public function getClientsByStatus($status = null)
    {
        if (isset($status))
        {
            $c = new Criteria();
            if (is_array($status)) $c->add(TradeExpertClientPeer::STATUS, $status, Criteria::IN);
            else $c->add(TradeExpertClientPeer::STATUS, $status);
            return $this->getTradeExpertClients($c);
        }

        $prods = $this->getTradeExpertClients();

        $prodArray = array();
        foreach ($prods as $prod)
        {
            if (!isset($prodArray[$prod->getApprovalStatus()])) $prodArray[$prod->getApprovalStatus()] = array();
            $prodArray[$prod->getApprovalStatus()][] = $prod;
        }
        return $prodArray;
    }
    
    public function getClientPager($page, $items_per_page = 20, $c1 = null, $status = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        if (isset($status)) $c->add(TradeExpertClientPeer::STATUS, $status);
        $c->add(TradeExpertClientPeer::TRADE_EXPERT_ID, $this->getId());
        
        $pager = new sfPropelPager('TradeExpertClient', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }

    public function getLogo()
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_LOGO);
        $c->add(MediaItemPeer::IS_TEMP, null, Criteria::ISNULL);
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
            return MediaItemPeer::retrieveItemsFor($this->getId() ? $this->getId() : 0, PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT, $c1);
        }
        
        if ($c1)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        
        return MediaItemPeer::doSelect($c);
    }

}
