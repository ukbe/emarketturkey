<?php

class articleAction extends EmtAction
{
    public function execute($request)
    {
        $this->kb_category = PublicationCategoryPeer::retrieveByPK(PublicationCategoryPeer::KNOWLEDGEBASE_CATEGORY_ID);

        $this->article = PublicationPeer::retrieveByStrippedTitle($this->getRequestParameter('stripped_title'));

        if (!$this->article || $this->article->getTypeId()!=PublicationPeer::PUB_TYP_ARTICLE)
        {
            $this->redirect404();
        }

        if (!$this->article->isKB()) $this->redirect($this->article->getUrl(), 301); // 301 = Moved Permanently

        $this->getResponse()->setTitle("{$this->article->getTitle()} | eMarketTurkey");

        $this->source = $this->article->getPublicationSource();
        $this->author = $this->article->getAuthor();
        $this->other_articles = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_ARTICLE, 5, $this->getUser()->getCulture(), $this->article->getSourceId(), null, null, $this->article->getId());
        $this->top_articles = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_ARTICLE, 5, $this->getUser()->getCulture(), null, null, $this->article->getCategoryId(), $this->article->getId());
        $this->colarticles = PublicationPeer::getColumnArticles();

        RatingPeer::logNewVisit($this->article->getId(), PrivacyNodeTypePeer::PR_NTYP_PUBLICATION);
    }
    
    public function handleError()
    {
    }
    
}
