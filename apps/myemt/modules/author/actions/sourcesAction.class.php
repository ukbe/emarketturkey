<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class sourcesAction extends EmtAuthorAction
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
        $this->sort = myTools::pick_from_list($this->getRequestParameter('sort'), array('id', 'name'), 'name');
        $this->dir = myTools::pick_from_list($this->getRequestParameter('dir'), array('asc', 'desc'), 'asc');
        
        $sortFields = array('id'        => PublicationSourcePeer::ID,
                            'name'     => PublicationSourceI18nPeer::DISPLAY_NAME,
                        );

        $c = new Criteria();
        
        if ($this->sort == 'name' || $this->keyword)
        {
            $c->addJoin(PublicationSourcePeer::ID, PublicationSourceI18nPeer::ID, Criteria::LEFT_JOIN);
        }

        if ($this->sort == 'name')
        {
            $c->addJoin(PublicationSourcePeer::ID, PublicationSourceI18nPeer::ID, Criteria::LEFT_JOIN);
            $c1 = $c->getNewCriterion(PublicationSourceI18nPeer::CULTURE, $this->getUser()->getCulture());
            $c2 = $c->getNewCriterion(PublicationSourceI18nPeer::CULTURE, null, Criteria::ISNULL);
            $c1->addOr($c2);
            $c->add($c1);
        }

        if ($this->dir == 'asc') $c->addAscendingOrderByColumn($sortFields[$this->sort]);
        else $c->addDescendingOrderByColumn($sortFields[$this->sort]);

        if ($this->keyword)
        {
            $c1 = $c->getNewCriterion(PublicationSourcePeer::NAME, myTools::NLSFunc(PublicationSourcePeer::NAME, 'UPPER') . " LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(PublicationSourceI18nPeer::DISPLAY_NAME, myTools::NLSFunc(PublicationSourceI18nPeer::DISPLAY_NAME, 'UPPER') . " LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c->add($c1);
        }
        
        $this->pager = PublicationSourcePeer::getPager($this->page, $this->ipp, $c);

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