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
        $this->redirect("@camp.articles?".http_build_query($params), 301);

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
