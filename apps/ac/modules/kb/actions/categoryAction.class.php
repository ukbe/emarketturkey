<?php

class categoryAction extends EmtAction
{
    public function execute($request)
    {
        $this->kb_category = PublicationCategoryPeer::retrieveByPK(PublicationCategoryPeer::KNOWLEDGEBASE_CATEGORY_ID);

        $c = new Criteria();
        $c->addJoin(PublicationCategoryPeer::ID, PublicationCategoryI18nPeer::ID, Criteria::LEFT_JOIN);
        $c->add(PublicationCategoryPeer::PARENT_ID, "
        EXISTS (
            SELECT 1 FROM (
                SELECT ID FROM EMT_PUBLICATION_CATEGORY
                START WITH ID=EMT_PUBLICATION_CATEGORY.ID
                CONNECT BY NOCYCLE PRIOR PARENT_ID = ID
            ) PREC
            WHERE PREC.ID=".PublicationCategoryPeer::KNOWLEDGEBASE_CATEGORY_ID."
        )
        ", Criteria::CUSTOM);
        $c->add(PublicationCategoryI18nPeer::STRIPPED_CATEGORY, $this->getRequestParameter('stripped_category'));
        $this->category = PublicationCategoryPeer::doSelectOne($c);
        if (!$this->category) $this->redirect404();

        $this->page = myTools::fixInt($this->getRequestParameter('page', 1));

        $c = new Criteria();
        $c->add(PublicationPeer::FEATURED_TYPE, null, Criteria::ISNULL);
        $c->add(PublicationPeer::ID, "EXISTS (SELECT 1 FROM EMT_PUBLICATION_I18N WHERE EMT_PUBLICATION_I18N.ID=EMT_PUBLICATION.ID AND EMT_PUBLICATION_I18N.CULTURE='{$this->getUser()->getCulture()}')", Criteria::CUSTOM);
        $this->pager = PublicationPeer::getPager($this->page, 10, $c, null, PublicationPeer::PUB_TYP_ARTICLE, null, $this->category->getId(), 1);
        
        $this->banner_articles = PublicationPeer::doSelectByTypeId(PublicationPeer::PUB_TYP_ARTICLE, false, $this->category->getId(), 5, true);
        $this->top_articles = PublicationPeer::getMostReadPublications(PublicationPeer::PUB_TYP_ARTICLE, 5, $this->getUser()->getCulture(), null, null, null, null, $this->category->getId());
        $this->colarticles = PublicationPeer::getColumnArticles(5, $this->category->getId());
        
        $this->categories = $this->kb_category->getSubCategories();
    }

    public function handleError()
    {
    }
    
}
