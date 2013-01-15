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

        $this->getResponse()->addMeta('description', $this->news->getSummary());

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
