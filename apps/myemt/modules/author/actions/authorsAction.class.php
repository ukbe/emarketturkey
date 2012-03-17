<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class authorsAction extends EmtAuthorAction
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
        $this->sort = myTools::pick_from_list($this->getRequestParameter('sort'), array('id', 'name', 'created'), 'name');
        $this->dir = myTools::pick_from_list($this->getRequestParameter('dir'), array('asc', 'desc'), 'asc');

        $sortFields = array('id'        => AuthorPeer::ID,
                            'name'      => AuthorI18nPeer::DISPLAY_NAME,
                            'created'   => AuthorPeer::CREATED_AT,
                        );

        $c = new Criteria();
        
        if ($this->sort == 'name' || $this->keyword)
        {
            $c->addJoin(AuthorPeer::ID, AuthorI18nPeer::ID, Criteria::LEFT_JOIN);
        }

        if ($this->sort == 'name')
        {
            $c->addJoin(AuthorPeer::ID, AuthorI18nPeer::ID, Criteria::LEFT_JOIN);
            $c1 = $c->getNewCriterion(AuthorI18nPeer::CULTURE, $this->getUser()->getCulture());
            $c2 = $c->getNewCriterion(AuthorI18nPeer::CULTURE, null, Criteria::ISNULL);
            $c1->addOr($c2);
            $c->add($c1);
        }

        if ($this->dir == 'asc') $c->addAscendingOrderByColumn($sortFields[$this->sort]);
        else $c->addDescendingOrderByColumn($sortFields[$this->sort]);

        if ($this->keyword)
        {
            $c1 = $c->getNewCriterion(AuthorPeer::NAME, myTools::NLSFunc(AuthorPeer::NAME . " || ' ' || " . AuthorPeer::NAME, 'UPPER') . " LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(AuthorI18nPeer::DISPLAY_NAME, myTools::NLSFunc(AuthorI18nPeer::DISPLAY_NAME, 'UPPER') . " LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c->add($c1);
        }
        
        $this->pager = AuthorPeer::getPager($this->page, $this->ipp, $c);

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