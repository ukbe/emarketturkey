<?php

class articleAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $this->article = PublicationPeer::retrieveByStrippedTitle($this->getRequestParameter('stripped_title'), true);
        if (!$this->article)
            $this->redirect("@camp.articles", 410); //  HTTP 410 : Gone!
        else
            $this->redirect($this->article->getUrl(), 301);
        
        if (!$this->article || $this->article->getTypeId()!=PublicationPeer::PUB_TYP_ARTICLE)
        {
            $this->redirect404();
        }

        $this->getResponse()->addMeta('description', $this->article->getSummary());

        $this->getResponse()->setTitle("{$this->article->getTitle()} | eMarketTurkey");

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
