<?php

class Publication extends BasePublication
{
    protected $_rating = null;
    private $hash = null;
    
    public function __toString()
    {
        return $this->getTitle() ? $this->getTitle() : $this->getDefaultTitle(); 
    }
    
    public function getDefaultTitle()
    {
        return $this->getTitle($this->getDefaultLang()); 
    }
    
    public function getDefaultShortTitle()
    {
        return $this->getShortTitle($this->getDefaultLang()); 
    }
    
    public function getShortTitleVsTitle()
    {
        $titles = array_filter(array($this->getDefaultTitle(), $this->getTitle(), $this->getDefaultShortTitle(), $this->getShortTitle()));
        return array_pop($titles);
    }
    
    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_PUBLICATION;
    }

    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_PUBLICATION) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getPicture()
    {
        $mis = MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_PUBLICATION);
        return count($mis)?$mis[0]:null;
    }
    
    public function getPictureUri($size = MediaItemPeer::LOGO_TYP_SMALL)
    {
        $pic = $this->getPicture();
        if ($pic)
        {
            switch ($size)
            {
                case MediaItemPeer::LOGO_TYPE_MEDIUM :
                    return $pic->getMediumUri();
                    break;
                case MediaItemPeer::LOGO_TYPE_LARGE :
                    return $pic->getUri();
                    break;
                case MediaItemPeer::LOGO_TYP_SMALL :
                default: 
                    return $pic->getThumbnailUri();
                    break;
            }
        }
        else
        {
            switch ($size)
            {
                case MediaItemPeer::LOGO_TYPE_MEDIUM :
                    return "layout/background/nologo.medium.".sfContext::getInstance()->getUser()->getCulture().".png";
                    break;
                case MediaItemPeer::LOGO_TYPE_LARGE :
                    return "layout/background/nologo.".sfContext::getInstance()->getUser()->getCulture().".png";
                    break;
                case MediaItemPeer::LOGO_TYP_SMALL :
                default: 
                    return "layout/background/nologo.thumb.".sfContext::getInstance()->getUser()->getCulture().".png";
                    break;
            }
        }
    }
    
    public function getPhotos()
    {
        return MediaItemPeer::retrieveItemsFor($this->getId() ? $this->getId() : 0, PrivacyNodeTypePeer::PR_NTYP_PUBLICATION);
    }
    
    public function getMediaItems($item_id = null, $type_id = null)
    {
        return MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_PUBLICATION, $type_id, $item_id);
    }
    
    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentPublicationI18n($culture);
        return $lsi->isNew()?false:true;
    }
    
    public function getClob($field, $culture = null)
    {
        if ($this->isNew()) return null;
        $conf = Propel::getConfiguration();
        $conf = $conf['datasources'][$conf['datasources']['default']]['connection'];
        
        if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
        if (!($c = @oci_connect($conf['user'], $conf['password'], $conf['database'])))
        {echo "no connection";}
        
        $sql = "SELECT $field 
                FROM EMT_PUBLICATION_I18N 
                WHERE ID={$this->getId()} AND CULTURE='$culture'";
        $stmt = oci_parse($c, $sql);
        oci_execute($stmt);
        $res = oci_fetch_row($stmt);

        return isset($res[0]) ? $res[0]->load() : "";
    }
    
    public function getBody($culture = null)
    {
        return $this->getClob(PublicationI18nPeer::CONTENT, $culture);
    }
    
    public function getOwner()
    {
        return $this->getAuthor();
    }

    public function getUrl()
    {
        $app = sfContext::getInstance()->getConfiguration()->getApplication();

        if ($this->isKB())
        {
            return $app == 'camp' ? "@kb-article?stripped_title=".$this->getStrippedTitle() : "@camp.kb-article?stripped_title=".$this->getStrippedTitle();
        }
        
        switch ($this->getTypeId())
        {
            case PublicationPeer::PUB_TYP_ARTICLE : return $app == 'camp' ? "@author-article?stripped_display_name={$this->getAuthor()->getStrippedDisplayName()}&stripped_title=".$this->getStrippedTitle() : "@camp.author-article?stripped_display_name={$this->getAuthor()->getStrippedDisplayName()}&stripped_title=".$this->getStrippedTitle();
            case PublicationPeer::PUB_TYP_NEWS : return $app == 'camp' ? "@news?stripped_title=".$this->getStrippedTitle() : "@camp.news?stripped_title=".$this->getStrippedTitle();
        }
        return "";
    }

    public function getEditUrl($act = 'edit')
    {
        $app = sfContext::getInstance()->getConfiguration()->getApplication();
        $app = ($app == 'myemt' ? "@" : "@myemt");
        $filter = sfContext::getInstance()->getRequest()->getParameter('filter');        
        $filter = $filter ? "&filter=$filter" : "";
        switch ($this->getTypeId())
        {
            case PublicationPeer::PUB_TYP_ARTICLE : return "{$app}author-action?action=article&id={$this->getId()}&act=$act$filter";
            case PublicationPeer::PUB_TYP_NEWS : return "{$app}author-action?action=news&id={$this->getId()}&act=$act$filter";
        }
    }

    public function getDefineText($to_user = null, $culture = null)
    {
        if (!$to_user) $to_user = sfContext::getInstance()->getUser()->getUser();
        $top_owner = PrivacyNodeTypePeer::getTopOwnerOf($this);
        $is_owner = ($top_owner && $to_user->getId() == $top_owner->getId()) ? true : false;
        $owner = $top_owner ? $top_owner : $this->getOwner();
        $source = $this->getPublicationSource();

        $i18n = sfContext::getInstance()->getI18N();
        $cl = $i18n->getCulture();
        $i18n->setCulture($culture);

        $result = "a publication";
        
        switch ($this->getTypeId())
        {
            case PublicationPeer::PUB_TYP_ARTICLE :
                $result = $is_owner ? $i18n->__("an article of you") : $i18n->__("an article of %1u", array('%1u' => $owner, 'sf_culture' => $culture));
                break;
            case PublicationPeer::PUB_TYP_NEWS :
                $result = $i18n->__("a news report by %1u", array('%1u' => $source, 'sf_culture' => $culture));
                break;
        }
        $i18n->setCulture($cl);
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
            
            $sql = "SELECT CULTURE FROM EMT_PUBLICATION_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(PublicationI18nPeer::ID, $this->getId());
        $c->add(PublicationI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return PublicationI18nPeer::doDelete($c);
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
    
    public function getRating()
    {
        return isset($this->_rating) ? $this->_rating : ($this->_rating = RatingPeer::getVisitCount($this->getId(), $this->getObjectTypeId()));
    }
    
    public function isKB()
    {
        $kbcat = PublicationCategoryPeer::retrieveByPK(PublicationCategoryPeer::KNOWLEDGEBASE_CATEGORY_ID);
        $parent = $this->getPublicationCategory();

        while ($parent && $parent->getId() != $kbcat->getId())
        {
            $parent = $parent->getParent();
        }
        
        return !is_null($parent);
    }

}
