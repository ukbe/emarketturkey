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

        $this->getResponse()->addMeta('description', $this->article->getSummary());

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
