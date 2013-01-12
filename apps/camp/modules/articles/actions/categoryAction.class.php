<?php

class categoryAction extends EmtAction
{
    protected $i18n_object_depended = true;

    public function execute($request)
    {
        $xcult = myTools::pick_from_list($this->getRequestParameter('x-cult'), sfConfig::get('app_i18n_cultures'), null);

        $this->category = PublicationCategoryPeer::retrieveByStrippedCategory($this->getRequestParameter('stripped_category'), $xcult);

        if (!$this->category) $this->redirect404();

        $urls = array();
        foreach (sfConfig::get('app_i18n_cultures') as $culture)
        {
            $urls[$culture] = "@articles-category?stripped_category=".$this->category->getStrippedCategory($culture)."&sf_culture=$culture";
        }

        if ($xcult)
        {
            $this->redirect($urls[$xcult]);
        }

        $this->getResponse()->addMeta('description', sfContext::getInstance()->getI18N()->__('Read various articles on %1cat', array('%1cat' => $this->category->__toString())));

        $this->getUser()->setCultureLinks($urls);

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
