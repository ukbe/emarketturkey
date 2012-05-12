<?php

class Author extends BaseAuthor
{
    public function __toString()
    {
        return $this->getDisplayName() ? $this->getDisplayName() : ($this->getDefaultDisplayName() ? $this->getDefaultDisplayName() : $this->getName() . ' ' . $this->getLastname()); 
    }
    
    public function getDefaultDisplayName()
    {
        return $this->getDisplayName($this->getDefaultLang()); 
    }
    
    public function getPicture()
    {
        $mis = MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_AUTHOR);
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
        return $this->getMediaItems();
    }
    
    public function getMediaItems($item_id = null, $type_id = null)
    {
        return MediaItemPeer::retrieveItemsFor($this->getId(), PrivacyNodeTypePeer::PR_NTYP_AUTHOR, $type_id, $item_id);
    }
    
    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentAuthorI18n($culture);
        return $lsi->isNew()?false:true;
    }
    
    public function getPublication($item_id=null, $item_type_id=null, $order_asc = false)
    {
        $c = new Criteria();
        if ($item_id) $c->add(PublicationPeer::ID, $item_id);
        $c->add(PublicationPeer::TYPE_ID, $item_type_id);
        $c->add(PublicationPeer::AUTHOR_ID, $this->getId());
        if ($order_asc) $c->addAscendingOrderByColumn(PublicationPeer::CREATED_AT);
        else $c->addDescendingOrderByColumn(PublicationPeer::CREATED_AT);
        
        $pubs = PublicationPeer::doSelect($c);
        return (isset($item_id) && count($pubs))?$pubs[0]:$pubs;
    }

    public function getArticle($item_id=null, $order_asc = false)
    {
        return $this->getPublication($item_id, PublicationPeer::PUB_TYP_ARTICLE, $order_asc);
    }

    public function getNews($item_id=null, $order_asc = false)
    {
        return $this->getPublication($item_id, PublicationPeer::PUB_TYP_NEWS, $order_asc);
    }

    public function getUrl($action = 'posts')
    {
        $app = sfContext::getInstance()->getConfiguration()->getApplication();
        $app = $app == 'ac' ? '' : "$app.";
        return "@{$app}author?action={$action}&stripped_display_name={$this->getStrippedDisplayName()}";
    }

    public function getAdjective()
    {
        return $this->getUser() ? $this->getUser()->getAdjective() : null;
    }
    
    public function getOwner()
    {
        return $this->getUser();
    }
    
    public function getPublicationPager($page, $items_per_page = 20, $c1 = null, $type_id = null, $source_id = null, $status = null)
    {
        return PublicationPeer::getPager($page, $items_per_page, $c1, $this->getId(), $type_id, $source_id, $status);
    }

    public function getEditUrl($act = 'edit')
    {
        $app = sfContext::getInstance()->getConfiguration()->getApplication();
        $app = ($app == 'myemt' ? "@" : "@myemt");
        
        return "{$app}author-action?action=author&id={$this->getId()}&act=$act";
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
            
            $sql = "SELECT CULTURE FROM EMT_AUTHOR_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(AuthorI18nPeer::ID, $this->getId());
        $c->add(AuthorI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return AuthorI18nPeer::doDelete($c);
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