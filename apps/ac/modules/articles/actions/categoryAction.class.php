<?php

class categoryAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $this->category = PublicationCategoryPeer::retrieveByStrippedCategory($this->getRequestParameter('stripped_category'), true);
        if (!$this->category) $this->redirect404();
        
        if ($this->hasRequestParameter('page')) $pagestr = "&page={$this->getRequestParameter('page')}";
        else $pagestr = '';
        
        $this->redirect("@camp.articles-category?stripped_category=".$this->category->getStrippedCategory().$pagestr, 301);

        $this->category = PublicationCategoryPeer::retrieveByStrippedCategory($this->getRequestParameter('stripped_category'));
        if (!$this->category) $this->redirect404();
        
        $this->getResponse()->addMeta('description', sfContext::getInstance()->getI18N()->__('Read various articles on %1cat', array('%1cat' => $this->category->__toString())));

        $this->banner_articles = PublicationPeer::doSelectByTypeId(PublicationPeer::PUB_TYP_ARTICLE, false, $this->category->getId(), 5);
        $this->top_articles = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_ARTICLE, 5, $this->getUser()->getCulture(), null, null, null, null, $this->category->getId());
        $this->colarticles = PublicationPeer::getColumnArticles(5, $this->category->getId());
        
        $this->page = myTools::fixInt($this->getRequestParameter('page', 1));

        $c = new Criteria();
        $c->add(PublicationPeer::FEATURED_TYPE, null, Criteria::ISNULL);
        $c->add(PublicationPeer::ID, "EXISTS (SELECT 1 FROM EMT_PUBLICATION_I18N WHERE EMT_PUBLICATION_I18N.ID=EMT_PUBLICATION.ID AND EMT_PUBLICATION_I18N.CULTURE='{$this->getUser()->getCulture()}')", Criteria::CUSTOM);
        $c->addDescendingOrderByColumn(PublicationPeer::CREATED_AT);
        $this->pager = PublicationPeer::getPager($this->page, 10, $c, null, PublicationPeer::PUB_TYP_ARTICLE, null, $this->category->getId(), 1);
        
        $this->categories = PublicationCategoryPeer::getBaseCategories();

        $this->kb_category = PublicationCategoryPeer::retrieveByPK(PublicationCategoryPeer::KNOWLEDGEBASE_CATEGORY_ID);
    }

    public function handleError()
    {
    }
    
}
