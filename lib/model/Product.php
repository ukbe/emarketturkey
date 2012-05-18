<?php

class Product extends BaseProduct
{
    private $paymentTerms = array();
    private $hash = null;
    
    public function __toString()
    {
        return ($this->getName() ? $this->getName() : $this->getDefaultName());
    }

    public function getDefaultName()
    {
        return $this->getName($this->getDefaultLang());
    }
    
    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_PRODUCT;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, $this->getObjectTypeId()) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getPhotos($limit=null)
    {
        $c = new Criteria();
        if (is_int($limit)) $c->setLimit($limit);
        
        $photos = $this->retrievePhotos($c);
        if ($limit === 1 && count($photos))
            return $photos[0];
        else
            return $photos;
    }
    
    public function getPhoto()
    {
        return $this->getPhotos(1);
    }
    
    public function retrievePhotos(Criteria $c1)
    {
        $c = clone $c1;
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_PRODUCT);
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
    
    public function getUrl($standalone = false, $tab = null)
    {
        $app =  sfContext::getInstance()->getConfiguration()->getApplication();
        if ($standalone) return ($app=='b2b'?'@':'@b2b.')."product-detail?id={$this->getId()}" . ($tab ? "&tab=$tab" : "");
        return $this->getCompany()->getProfileActionUrl('product') . "&id={$this->getId()}" . ($tab ? "&tab=$tab" : "");
    }
    
    public function getPhotoUrl($standalone = false, $photo_id)
    {
        $app =  sfContext::getInstance()->getConfiguration()->getApplication();
        if ($standalone) return ($app=='b2b'?'@':'@b2b.')."product-detail?id={$this->getId()}&photo=$photo_id";
        return $this->getCompany()->getProfileActionUrl('product') . "&id={$this->getId()}&photo=$photo_id";
    }
    
    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentProductI18n($culture);
        return $lsi->isNew()?false:true;
    }
    
    public function getPhotoById($id_or_guid)
    {
        $item = MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_PRODUCT, null, $id_or_guid);
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

        $result = $i18n->__("a product");
        
        $result = $is_owner ? $i18n->__("a product of your company %1c", array('%1c' => $owner)) : $i18n->__("a product of %1c", array('%1c' => $owner));

        if ($target_culture) $i18n->setCulture($cl);
        return $result;
    }
    
    public function getEditUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . "edit-product?hash={$this->getOwner()->getHash()}&id={$this->getId()}";  
    }

    public function getManageUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . "product-details?hash={$this->getOwner()->getHash()}&id={$this->getId()}";  
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
            
            $sql = "SELECT CULTURE FROM EMT_PRODUCT_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(ProductI18nPeer::ID, $this->getId());
        $c->add(ProductI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return ProductI18nPeer::doDelete($c);
    }
    
    public function getAttributeMatrix()
    {
        $con = Propel::getConnection();
        
        $sql = "SELECT EMT_PRODUCT_ATTR.* FROM EMT_PRODUCT_ATTR
                LEFT JOIN EMT_PRODUCT_ATTR_OPTION ON EMT_PRODUCT_ATTR.ATTR_OPTION_ID=EMT_PRODUCT_ATTR_OPTION.ID 
                LEFT JOIN EMT_PRODUCT_ATTR_DEF ON EMT_PRODUCT_ATTR_OPTION.ATTRIBUTE_ID=EMT_PRODUCT_ATTR_DEF.ID 
                WHERE EMT_PRODUCT_ATTR.PRODUCT_ID={$this->getId()}
                ORDER BY EMT_PRODUCT_ATTR_DEF.SEQUENCE_NO, EMT_PRODUCT_ATTR_OPTION.SEQUENCE_NO ASC";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        $attrs = ProductAttrPeer::populateObjects($stmt);
        $matrix = array('qualified' => array(), 'unqualified' => array());
        
        foreach ($attrs as $attr) {
            if (($opt = $attr->getProductAttrOption()))
                $matrix['qualified'][$opt->getAttributeId()] = $attr;
            else
                $matrix['unqualified'][$attr->getId()] = $attr;
        }
        return $matrix;
    }
    
    public function setAttributes($matrix)
    {
        $current = $this->getAttributeMatrix();
        
        foreach ($current as $type => $array)
        {
            reset($matrix[$type]);
            foreach ($array as $key => $attr)
            {
                $arr = current($matrix[$type]);
                if ($type == 'qualified' && !is_null($arr))
                {
                    $attr->setAttrOptionId($arr);
                    $attr->save();
                }
                elseif ($type == 'unqualified' && !is_null($arr))
                {
                    $attr->setProductId($this->getId());
                    $attr->setAttrOptionId(null);
                    $attr->save();
                    
                    $attr->setName(key($matrix[$type]));
                    $attr->setValue($arr);
                    $attr->save();
                }
                else
                {
                    $att->delete();
                }
                next($matrix[$type]);
            }
        }
        
        while ($arr = current($matrix['qualified']))
        {
            $attr = new ProductAttr();
            $attr->setProductId($this->getId());
            $attr->setAttrOptionId($arr);
            $attr->save();
            next($matrix['qualified']);
        }

        while ($arr = current($matrix['unqualified']))
        {
            $attr = new ProductAttr();
            $attr->setProductId($this->getId());
            $attr->setAttrOptionId(null);
            $attr->save();
            
            $attr->setName(key($matrix['unqualified']));
            $attr->setValue($arr);
            $attr->save();
            
            next($matrix['unqualified']);
        }
    }
    
    public function getAbsBrandName()
    {
        return $this->getCompanyBrand() ? $this->getCompanyBrand()->getName() : $this->getBrandName();
    }
    
    public function getNameByPriority()
    {
        return $this->getName() ? $this->getName() : $this->getName($this->getDefaultLang());
    }
    
    public function isApproved()
    {
        return $this->getApprovalStatus() == ProductPeer::PR_STAT_APPROVED;
    }
    
    public function isOnline()
    {
        return $this->isApproved() && $this->getActive();
    }
    
    public function getPriceText()
    {
        $from = $this->getPriceStart();
        $to = $this->getPriceEnd();
        $curr = $this->getPriceCurrency();
        $unit = $this->getProductQuantityUnitRelatedByPriceUnit();

        sfLoader::loadHelpers(array('I18N', 'Number'));

        $price = ($from && $to ? __('from %1start up to %2end', array('%1start' => format_currency($from, $curr), '%2end' => format_currency($to, $curr))) 
                                                             : ($from ? __('from %1start', array('%1start' => format_currency($from, $curr))) 
                                                                      : ($to ? __('up to %1end', array('%1end' => format_currency($to, $curr))) : '')
                                                               )
                 );

        $amount =  ($unit ? $unit : '');

        return $price && $amount ? __('%1price per %2amount', array('%1price' => $price, '%2amount' => $amount))
                                 : ($price ? $price : ($amount ? $amount : '')) ;
    }
    
}
