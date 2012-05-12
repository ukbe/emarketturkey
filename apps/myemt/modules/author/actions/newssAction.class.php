<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class newssAction extends EmtAuthorAction
{

    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $this->page = myTools::fixInt($this->getRequestParameter('page'));
        $this->filter = myTools::pick_from_list($this->getRequestParameter('filter'), array('none'), null);
        $this->keyword = $this->getRequestParameter('keyword');
        $this->sort = myTools::pick_from_list($this->getRequestParameter('sort'), array('id', 'title', 'category', 'source', 'publish'), 'id');
        $this->dir = myTools::pick_from_list($this->getRequestParameter('dir'), array('asc', 'desc'), 'asc');
        $this->ipp = myTools::pick_from_list($this->getRequestParameter('ipp'), array(10, 20, 50), 20);
        
        $sortFields = array('id'        => PublicationPeer::ID,
                            'title'     => PublicationI18nPeer::TITLE,
                            'category'  => PublicationCategoryI18nPeer::NAME,
                            'source'    => PublicationSourceI18nPeer::DISPLAY_NAME,
                            'publish'   => PublicationPeer::CREATED_AT,
                        );

        $c = new Criteria();
        
        if ($this->sort == 'title' || $this->keyword)
        {
            $c->addJoin(PublicationPeer::ID, PublicationI18nPeer::ID, Criteria::LEFT_JOIN);
        }

        if ($this->sort == 'category')
        {
            $c->addJoin(PublicationPeer::CATEGORY_ID, PublicationCategoryI18nPeer::ID, Criteria::LEFT_JOIN);
            $c1 = $c->getNewCriterion(PublicationCategoryI18nPeer::CULTURE, $this->getUser()->getCulture());
            $c2 = $c->getNewCriterion(PublicationCategoryI18nPeer::CULTURE, null, Criteria::ISNULL);
            $c1->addOr($c2);
            $c->add($c1);
        }

        if ($this->sort == 'source')
        {
            $c->addJoin(PublicationPeer::SOURCE_ID, PublicationSourceI18nPeer::ID, Criteria::LEFT_JOIN);
            $c1 = $c->getNewCriterion(PublicationSourceI18nPeer::CULTURE, $this->getUser()->getCulture());
            $c2 = $c->getNewCriterion(PublicationSourceI18nPeer::CULTURE, null, Criteria::ISNULL);
            $c1->addOr($c2);
            $c->add($c1);
        }

        if ($this->dir == 'asc') $c->addAscendingOrderByColumn($sortFields[$this->sort]);
        else $c->addDescendingOrderByColumn($sortFields[$this->sort]);

        if ($this->keyword)
        {
            $c1 = $c->getNewCriterion(PublicationI18nPeer::TITLE, myTools::NLSFunc(PublicationI18nPeer::TITLE, 'UPPER') . " LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(PublicationI18nPeer::SUMMARY, myTools::NLSFunc(PublicationI18nPeer::SUMMARY, 'UPPER') . " LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c3 = $c->getNewCriterion(PublicationI18nPeer::INTRODUCTION, myTools::NLSFunc(PublicationI18nPeer::INTRODUCTION, 'UPPER') . " LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c4 = $c->getNewCriterion(PublicationI18nPeer::CONTENT, myTools::NLSFunc(PublicationI18nPeer::CONTENT, 'UPPER') . " LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c1->addOr($c3);
            $c1->addOr($c4);
            $c->add($c1);
        }
        
        if (!$this->filter)
            $this->pager = $this->author->getPublicationPager($this->page, $this->ipp, $c, PublicationPeer::PUB_TYP_NEWS);
        else
            $this->pager = PublicationPeer::getPager($this->page, $this->ipp, $c, null, PublicationPeer::PUB_TYP_NEWS);

    }

    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}