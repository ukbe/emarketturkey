<?php

class articleAction extends EmtAction
{
    protected $i18n_object_depended = true;

    public function execute($request)
    {
        $xcult = myTools::pick_from_list($this->getRequestParameter('x-cult'), sfConfig::get('app_i18n_cultures'), null);

        $this->article = PublicationPeer::retrieveByStrippedTitle($this->getRequestParameter('stripped_title'), $xcult);

        if (!$this->article || $this->article->getTypeId()!=PublicationPeer::PUB_TYP_ARTICLE)
        {
            if ($article = PublicationPeer::retrieveByStrippedTitle($this->getRequestParameter('stripped_title'), true))
                $this->redirect($article->getUrl(), 301);
            $this->redirect404();
        }

        $urls = array();
        foreach (sfConfig::get('app_i18n_cultures') as $culture)
        {
            $urls[$culture] = $this->article->getUrl($culture);
            if (!isset($urls[$culture]) || is_null($urls[$culture])) $urls[$culture] = "@articles?sf_culture=$culture";
        }

        if ($xcult)
        {
            $this->redirect($urls[$xcult]);
            
        }

        $this->getResponse()->setItemType('http://schema.org/NewsArticle');
        
        $this->getResponse()->addObjectMeta(array('name' => 'description', 'itemprop' => 'description'), $this->article->getSummary());
        $this->getResponse()->addObjectMeta(array('name' => 'title', 'itemprop' => 'headline'), $this->article->getTitle());
        $this->getResponse()->addObjectMeta(array('name' => 'author', 'itemprop' => 'author'), $this->article->getAuthor()->__toString());
        if ($this->article->getPublicationSource()) $this->getResponse()->addObjectMeta(array('name' => 'source', 'itemprop' => 'sourceOrganisation'), $this->article->getPublicationSource()->__toString());
        $this->getResponse()->addObjectMeta(array('name' => 'medium', 'itemprop' => 'genre'), 'Article');
        $this->getResponse()->addObjectMeta(array('name' => 'section', 'itemprop' => 'articleSection'), $this->article->getPublicationCategory()->getTopCategory()->__toString());
        $this->getResponse()->addObjectMeta(array('name' => 'pubdate', 'itemprop' => 'datePublished'), $this->article->getCreatedAt('Y-m-d\TH:i:s\Z'));
        $this->getResponse()->addObjectMeta(array('name' => 'lastmod', 'itemprop' => 'dateModified'), $this->article->getUpdatedAt('Y-m-d\TH:i:s\Z'));
        $this->getResponse()->addObjectMeta(array('itemprop' => 'dateCreated'), $this->article->getCreatedAt('Y-m-d\TH:i:s\Z'));
        $this->getResponse()->addObjectMeta(array('http-equiv' => 'last-modified'), $this->article->getUpdatedAt('Y-m-d\TH:i:s\Z'));
        sfLoader::loadHelpers('Url');
        $this->getResponse()->addObjectMeta(array('itemprop' => 'url'), url_for($this->article->getUrl(), true));
        $this->getResponse()->addObjectMeta(array('itemprop' => 'thumbnailUrl'), url_for($this->article->getPicture()->getThumbnailUri(), true));
        $this->getResponse()->addObjectMeta(array('name' => 'language', 'itemprop' => 'inLanguage'), $this->getUser()->getCulture());
        
        $this->getResponse()->setTitle("{$this->article->getTitle()} | eMarketTurkey");

        $this->getUser()->setCultureLinks($urls);

        $this->source = $this->article->getPublicationSource();
        $this->author = $this->article->getAuthor();
        $this->other_articles = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_ARTICLE, 5, $this->getUser()->getCulture(), null, $this->author->getId(), null, $this->article->getId());
        $this->top_articles = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_ARTICLE, 5, $this->getUser()->getCulture(), null, null, $this->article->getCategoryId(), $this->article->getId());
        $this->colarticles = PublicationPeer::getColumnArticles();

        RatingPeer::logNewVisit($this->article->getId(), PrivacyNodeTypePeer::PR_NTYP_PUBLICATION);
    }
    
    public function handleError()
    {
    }
    
}
