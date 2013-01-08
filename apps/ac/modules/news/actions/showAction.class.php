<?php

class showAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['action']);
        unset($params['sf_culture']);
        $this->redirect("@camp.news?".http_build_query($params), 301);

        $this->news = PublicationPeer::retrieveByStrippedTitle($this->getRequestParameter('stripped_title'));

        if (!$this->news || $this->news->getTypeId()!=PublicationPeer::PUB_TYP_NEWS)
        {
            $this->redirect404();
        }
        
        $this->getResponse()->addMeta('description', $this->news->getSummary());

        $this->getResponse()->setTitle("{$this->news->getTitle()} | eMarketTurkey");

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
