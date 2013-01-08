<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['action']);
        unset($params['sf_culture']);
        $this->redirect("@camp.kb?".http_build_query($params), 301);

        $this->kb_category = PublicationCategoryPeer::retrieveByPK(PublicationCategoryPeer::KNOWLEDGEBASE_CATEGORY_ID);

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
