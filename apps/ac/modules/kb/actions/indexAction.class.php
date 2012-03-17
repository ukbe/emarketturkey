<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $this->kb_category = PublicationCategoryPeer::retrieveByPK(48);

        $columnsTypes = array_keys(PublicationCategoryPeer::getBaseCategories(null, true, $this->kb_category->getId()));
        $this->sectarticles = PublicationPeer::doSelectArticlesByCategory(false, $columnsTypes, PublicationPeer::PUB_FEATURED_COLUMN, null, 5, true);
        
        $this->banner_articles = PublicationPeer::doSelectByTypeId(PublicationPeer::PUB_TYP_ARTICLE, false, $this->kb_category->getId(), 5, PublicationPeer::PUB_FEATURED_BANNER, true);
        $this->top_articles = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_ARTICLE, 5, $this->getUser()->getCulture(), null, null, $this->kb_category->getId());
        $this->colarticles = PublicationPeer::getColumnArticles(5, $this->kb_category->getId());
        
        $this->categories = PublicationCategoryPeer::getBaseCategories(null, false, $this->kb_category->getId());
    }

    public function handleError()
    {
    }
    
}
