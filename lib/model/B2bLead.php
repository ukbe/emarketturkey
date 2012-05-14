<?php

class B2bLead extends BaseB2bLead
{
    private $paymentTerms = array();
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
        return PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getTypeCode()
    {
        return $this->getTypeId() == B2bLeadPeer::B2B_LEAD_BUYING ? 'buying' : ($this->getTypeId() == B2bLeadPeer::B2B_LEAD_SELLING ? 'selling' : null);
    }

    public function getEditUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . "edit-lead?hash={$this->getCompany()->getHash()}&id={$this->getId()}";  
    }

    public function getPhotos($limit=null)
    {
        $c = new Criteria();
        if (is_int($limit)) $c->setLimit($limit);
        
        $photos = $this->retrievePhotos($c);
        if ($limit === 1)
            return count($photos) ? $photos[0] : null;
        else
            return $photos;
    }
    
    public function retrievePhotos(Criteria $c1)
    {
        $c = clone $c1;
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD);
        $c->add(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_PRODUCT_PICTURE);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId() ? $this->getId() : 0);
        
        return MediaItemPeer::doSelect($c);
    }
    
    public function getPhotoUri($size='L')
    {
        $profile_picture = $this->getPhotos(1);
        $nophoto = "content/product/no_photo_provided.png";
        $path = array('L' => "content/product/no_photo_provided.png",
                      'M' => "content/product/thumb/no_photo_providedM.png",
                      'S' => "content/product/thumb/no_photo_provided.png");
        
        if (!$profile_picture)
        {
            return $path[$size];
        }
        else
        {
            if ($size=='S')
            {
                if (file_exists($profile_picture->getThumbnailPath())) return $profile_picture->getThumbnailUri();
                else return $path['S'];
            }
            elseif ($size=='M')
            {
                if (file_exists($profile_picture->getMediumPath())) return $profile_picture->getMediumUri();
                else return $path['M'];
            }
            else
            {
                if (file_exists($profile_picture->getPath())) return $profile_picture->getUri();
                else return $path['L'];
            }
        }
    }
    
    public function getThumbUri()
    {
        return $this->getPhotoUri('S');
    }
    
    public function getMediumUri()
    {
        return $this->getPhotoUri('M');
    }
    
    public function getPictureUri()
    {
        return $this->getPhotoUri('L');
    }
    
    public function getUrl()
    {
        $app =  sfContext::getInstance()->getConfiguration()->getApplication();
        return ($app=='b2b'?'@':'@b2b.')."lead-detail?guid={$this->getGuid()}";
    }
    
    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentB2bLeadI18n($culture);
        return $lsi->isNew()?false:true;
    }
    
    public function getPhotoById($id_or_guid)
    {
        $item = MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD, null, $id_or_guid);
        return count($item) ? $item[0] : null;
    }
    
    public function hasPaymentTerm($pid)
    {
        if (!$this->paymentTerms)
        {
            $this->paymentTerms = unserialize($this->getPaymentTerms());
        }
        return in_array($pid, $this->paymentTerms);
    }
    
    public function getPaymentTermList()
    {
        $pts = unserialize($this->getPaymentTerms());
        $c = new Criteria();
        $c->add(PaymentTermPeer::ID, $pts, Criteria::IN);
        $c->addAscendingOrderByColumn(PaymentTermI18nPeer::NAME);
        return PaymentTermPeer::doSelectWithI18n($c);
    }
    
    public function getOwner()
    {
        return $this->getCompany();
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

        $lead_type = $this->getTypeId() == B2bLeadPeer::B2B_LEAD_BUYING ? 'a buying lead' : 'a selling lead';

        $result = $lead_type;
        
        $result = $is_owner ? $i18n->__("$lead_type of your company %1c", array('%1c' => $owner)) : $i18n->__("$lead_type of %1c", array('%1c' => $owner));

        if ($target_culture) $i18n->setCulture($cl);
        return $result;
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
            
            $sql = "SELECT CULTURE FROM EMT_B2B_LEAD_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }

    public function getNameByPriority()
    {
        return $this->getName() ? $this->getName() : $this->getName($this->getDefaultLang());
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(B2bLeadI18nPeer::ID, $this->getId());
        $c->add(B2bLeadI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return B2bLeadI18nPeer::doDelete($c);
    }
    
    public function getPhotoUrl($photo_id)
    {
        $app =  sfContext::getInstance()->getConfiguration()->getApplication();
        return $this->getUrl() . "&photo=$photo_id";
    }
    
}
