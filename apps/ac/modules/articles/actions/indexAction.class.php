<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $columnsTypes = array_keys(PublicationCategoryPeer::getBaseCategories(null, true));
        $this->sectarticles = PublicationPeer::doSelectArticlesByCategory(false, $columnsTypes, PublicationPeer::PUB_FEATURED_COLUMN, null, 5, true);
        
        $this->banner_articles = PublicationPeer::doSelectByTypeId(PublicationPeer::PUB_TYP_ARTICLE, false, null, 5, PublicationPeer::PUB_FEATURED_BANNER);
        $this->top_articles = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_ARTICLE, 5, $this->getUser()->getCulture());
        $this->colarticles = PublicationPeer::getColumnArticles();
        
        $this->categories = PublicationCategoryPeer::getBaseCategories();

        $this->kb_category = PublicationCategoryPeer::retrieveByPK(PublicationCategoryPeer::KNOWLEDGEBASE_CATEGORY_ID);
    }

    public function handleError()
    {
    }
    
}
