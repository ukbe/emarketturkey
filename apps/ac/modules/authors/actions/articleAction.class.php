<?php

class articleAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['action']);
        unset($params['sf_culture']);
        $this->redirect("@camp.author-article?".http_build_query($params), 301);

        $this->article = PublicationPeer::retrieveByStrippedTitle($this->getRequestParameter('stripped_title'));

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
