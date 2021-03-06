<?php

class PublicationSource extends BasePublicationSource
{
    private $hash = null;

    public function __toString()
    {
        return $this->getDisplayName() ? $this->getDisplayName() : $this->getDefaultName(); 
    }
    
    public function getDefaultName()
    {
        return $this->getDisplayName($this->getDefaultLang()); 
    }

    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_PUBLICATION_SOURCE;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, $this->getObjectTypeId()) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getPicture()
    {
        $mis = MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_PUBLICATION_SOURCE);
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
        return MediaItemPeer::retrieveItemsFor($this->getId() ? $this->getId() : 0, PrivacyNodeTypePeer::PR_NTYP_PUBLICATION_SOURCE);
    }
    
    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentPublicationSourceI18n($culture);
        return $lsi->isNew()?false:true;
    }

    public function getEditUrl($act = 'edit')
    {
        $app = sfContext::getInstance()->getConfiguration()->getApplication();
        $app = ($app == 'myemt' ? "@" : "@myemt");
        
        return "{$app}author-action?action=source&id={$this->getId()}&act=$act";
    }

    public function getUrl($type = 1, $culture = null)
    {
        // $type = 1  -> Article
        //         2  -> News
        $app = sfContext::getInstance()->getConfiguration()->getApplication();

        if (!$culture)
        {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }
        else
        {
            if (!$this->hasLsiIn($culture)) return null;
        }

        switch ($type)
        {
            case PublicationPeer::PUB_TYP_ARTICLE : return $app == 'camp' ? "@article-source?stripped_display_name={$this->getStrippedDisplayName($culture)}&sf_culture=$culture" : "@camp.article-source?stripped_display_name={$this->getStrippedDisplayName($culture)}&sf_culture=$culture";
            case PublicationPeer::PUB_TYP_NEWS : return $app == 'camp' ? "@news-source?stripped_display_name={$this->getStrippedDisplayName($culture)}&sf_culture=$culture" : "@camp.news-source?stripped_display_name={$this->getStrippedDisplayName($culture)}&sf_culture=$culture";
        }
        return null;
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
            
            $sql = "SELECT CULTURE FROM EMT_PUBLICATION_SOURCE_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(PublicationSourceI18nPeer::ID, $this->getId());
        $c->add(PublicationSourceI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return PublicationSourceI18nPeer::doDelete($c);
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
