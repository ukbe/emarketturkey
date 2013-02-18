<?php

class showAction extends EmtAction
{
    protected $i18n_object_depended = true;

    public function execute($request)
    {
        $xcult = myTools::pick_from_list($this->getRequestParameter('x-cult'), sfConfig::get('app_i18n_cultures'), null);

        $this->news = PublicationPeer::retrieveByStrippedTitle($this->getRequestParameter('stripped_title'), $xcult);

        if (!$this->news || $this->news->getTypeId()!=PublicationPeer::PUB_TYP_NEWS)
        {
            if ($news = PublicationPeer::retrieveByStrippedTitle($this->getRequestParameter('stripped_title'), true))
                $this->redirect($news->getUrl(), 301);
            $this->redirect404();
        }

        $urls = array();
        foreach (sfConfig::get('app_i18n_cultures') as $culture)
        {
            $urls[$culture] = $this->news->getUrl($culture);
            if (!isset($urls[$culture]) || is_null($urls[$culture])) $urls[$culture] = "@news-home?sf_culture=$culture";
        }

        if ($xcult)
        {
            $this->redirect($urls[$xcult]);
        }

        $this->getResponse()->setItemType('http://schema.org/NewsArticle');
        
        $this->getResponse()->addObjectMeta(array('name' => 'description', 'itemprop' => 'description'), $this->news->getSummary());
        $this->getResponse()->addObjectMeta(array('name' => 'title', 'itemprop' => 'headline'), $this->news->getTitle());
        $this->getResponse()->addObjectMeta(array('name' => 'author', 'itemprop' => 'author'), $this->news->getAuthor()->__toString());
        if ($this->news->getPublicationSource()) $this->getResponse()->addObjectMeta(array('name' => 'source', 'itemprop' => 'sourceOrganization'), $this->news->getPublicationSource()->__toString());
        $this->getResponse()->addObjectMeta(array('name' => 'medium', 'itemprop' => 'genre'), 'News');
        $this->getResponse()->addObjectMeta(array('name' => 'section', 'itemprop' => 'articleSection'), $this->news->getPublicationCategory()->getTopCategory()->__toString());
        $this->getResponse()->addObjectMeta(array('name' => 'pubdate', 'itemprop' => 'datePublished'), $this->news->getCreatedAt('Y-m-d\TH:i:s\Z'));
        $this->getResponse()->addObjectMeta(array('name' => 'lastmod', 'itemprop' => 'dateModified'), $this->news->getUpdatedAt('Y-m-d\TH:i:s\Z'));
        $this->getResponse()->addObjectMeta(array('itemprop' => 'dateCreated'), $this->news->getCreatedAt('Y-m-d\TH:i:s\Z'));
        $this->getResponse()->addObjectMeta(array('http-equiv' => 'last-modified'), $this->news->getUpdatedAt('Y-m-d\TH:i:s\Z'));
        sfLoader::loadHelpers('Url');
        $this->getResponse()->addObjectMeta(array('itemprop' => 'url'), url_for($this->news->getUrl(), true));
        if ($this->news->getPicture()) $this->getResponse()->addObjectMeta(array('itemprop' => 'thumbnailUrl'), url_for($this->news->getPicture()->getThumbnailUri(), true));
        $this->getResponse()->addObjectMeta(array('name' => 'language', 'itemprop' => 'inLanguage'), $this->getUser()->getCulture());

        $this->getResponse()->setTitle("{$this->news->getTitle()} | eMarketTurkey");

        $this->getUser()->setCultureLinks($urls);

        $this->source = $this->news->getPublicationSource();
        $this->other_news = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_NEWS, 5, $this->getUser()->getCulture(), $this->source->getId(), null, null, $this->news->getId());
        $this->top_news = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_NEWS, 5, $this->getUser()->getCulture(), null, null, $this->news->getCategoryId(), $this->news->getId());
        $this->colarticles = PublicationPeer::getColumnArticles();
        
        RatingPeer::logNewVisit($this->news->getId(), PrivacyNodeTypePeer::PR_NTYP_PUBLICATION);
    }
    
    public function handleError()
    {
    }
    
}
