<?php

class categoryAction extends EmtAction
{
    public function execute($request)
    {
        $this->kb_category = PublicationCategoryPeer::retrieveByPK(48);

        $c = new Criteria();
        $c->addJoin(PublicationCategoryPeer::ID, PublicationCategoryI18nPeer::ID, Criteria::LEFT_JOIN);
        $c->add(PublicationCategoryPeer::PARENT_ID, $this->kb_category->getId());
        $c->add(PublicationCategoryI18nPeer::STRIPPED_CATEGORY, $this->getRequestParameter('stripped_category'));
        $this->category = PublicationCategoryPeer::doSelectOne($c);
        if (!$this->category) $this->redirect404();

        $this->banner_articles = PublicationPeer::doSelectByTypeId(PublicationPeer::PUB_TYP_ARTICLE, false, $this->category->getId(), 5, true);
        $this->top_articles = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_ARTICLE, 5, $this->getUser()->getCulture(), null, null, null, null, $this->category->getId());
        $this->colarticles = PublicationPeer::getColumnArticles(5, $this->category->getId());
        
        $this->categories = $this->kb_category->getSubCategories();
    }

    public function handleError()
    {
    }
    
}
