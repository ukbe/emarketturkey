<?php

class categoryAction extends EmtAction
{
    public function execute($request)
    {
        $this->category = PublicationCategoryPeer::retrieveByStrippedCategory($this->getRequestParameter('stripped_category'));
        if (!$this->category) $this->redirect404();

        $this->banner_news = PublicationPeer::doSelectByTypeId(PublicationPeer::PUB_TYP_NEWS, false, $this->category->getId(), 5);
        $this->top_news = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_NEWS, 5, $this->getUser()->getCulture(), null, null, null, null, $this->category->getId());
        $this->colarticles = PublicationPeer::getColumnArticles(5, $this->category->getId());
        
        $this->categories = PublicationCategoryPeer::getBaseCategories();

        $this->kb_category = PublicationCategoryPeer::retrieveByPK(PublicationCategoryPeer::KNOWLEDGEBASE_CATEGORY_ID);
    }

    public function handleError()
    {
    }
    
}
