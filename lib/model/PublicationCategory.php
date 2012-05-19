<?php

class PublicationCategory extends BasePublicationCategory
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
        return PrivacyNodeTypePeer::PR_NTYP_PUBLICATION_CATEGORY;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, $this->getObjectTypeId()) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getSubCategories($for_select = false)
    {
        return PublicationCategoryPeer::getBaseCategories(null, $for_select, $this->getId());
    }
    
    public function getParent()
    {
        return PublicationCategoryPeer::retrieveByPK($this->getParentId());
    }

    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentPublicationCategoryI18n($culture);
        return $lsi->isNew()?false:true;
    }

    public function getPicture()
    {
        $mis = MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_PUBLICATION_CATEGORY);
        return count($mis)?$mis[0]:null;
    }
    
    public function getPictureUri($large=false)
    {
        $pic = $this->getPicture();
        if ($pic)
        {
            return $large?$pic->getUri():$pic->getThumbnailUri();
        }
        else
        {
            return $large?"layout/background/nologo.".sfContext::getInstance()->getUser()->getCulture().".png"
                         :"layout/background/nologo.thumb.".sfContext::getInstance()->getUser()->getCulture().".png";
        }
    }
    
    public function getPhotos()
    {
        return MediaItemPeer::retrieveItemsFor($this->getId() ? $this->getId() : 0, PrivacyNodeTypePeer::PR_NTYP_PUBLICATION_CATEGORY);
    }
    
    public function getEditUrl($act = 'edit')
    {
        $app = sfContext::getInstance()->getConfiguration()->getApplication();
        $app = ($app == 'myemt' ? "@" : "@myemt");
        
        return "{$app}author-action?action=category&id={$this->getId()}&act=$act";
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
            
            $sql = "SELECT CULTURE FROM EMT_PUBLICATION_CATEGORY_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(PublicationCategoryI18nPeer::ID, $this->getId());
        $c->add(PublicationCategoryI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return PublicationCategoryI18nPeer::doDelete($c);
    }
    
    public function deActivate()
    {
        $this->setActive(false);
        $this->save();
    }
    public function activate()
    {
        $this->setActive(true);
        $this->save();
    }
}