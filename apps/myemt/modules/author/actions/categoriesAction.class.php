<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class categoriesAction extends EmtAuthorAction
{

    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $this->ipp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ipp')), array(10, 20, 50), 20);
        $this->page = myTools::fixInt($this->getRequestParameter('page'));
        $this->filter = myTools::pick_from_list($this->getRequestParameter('filter'), array('none'), null);
        $this->keyword = $this->getRequestParameter('keyword');
        $this->sort = myTools::pick_from_list($this->getRequestParameter('sort'), array('id', 'name', 'parent'), 'id');
        $this->dir = myTools::pick_from_list($this->getRequestParameter('dir'), array('asc', 'desc'), 'asc');
        
        $sortFields = array('id'        => PublicationCategoryPeer::ID,
                            'name'      => PublicationCategoryI18nPeer::NAME,
                            'parent'    => "PARENTSRC.NAME",
                        );

        $wheres = $joins = array();

        if ($this->sort == 'name' || $this->keyword)
        {
            $joins[] = "LEFT JOIN EMT_PUBLICATION_CATEGORY_I18N ON EMT_PUBLICATION_CATEGORY.ID=EMT_PUBLICATION_CATEGORY_I18N.ID AND EMT_PUBLICATION_CATEGORY_I18N.CULTURE='{$this->getUser()->getCulture()}'";
        }

        if ($this->sort == 'parent')
        {
            $joins[] = "LEFT JOIN EMT_PUBLICATION_CATEGORY_I18N PARENTSRC ON EMT_PUBLICATION_CATEGORY.PARENT_ID=PARENTSRC.ID AND PARENTSRC.CULTURE='{$this->getUser()->getCulture()}'";
        }

        if ($this->keyword)
        {
            $wheres[] = "(
                " . myTools::NLSFunc(PublicationCategoryPeer::NAME, 'UPPER') . "='%" . myTools::NLSFunc($this->keyword, 'UPPER') . "%'
                    OR
                " . myTools::NLSFunc(PublicationCategoryI18nPeer::DISPLAY_NAME, 'UPPER') . "='%" . myTools::NLSFunc($this->keyword, 'UPPER') . "%'
                    OR
                " . myTools::NLSFunc(PublicationCategoryI18nPeer::DESCRIPTION, 'UPPER') . "='%" . myTools::NLSFunc($this->keyword, 'UPPER') . "%'
                ";
        }

        $sql = "SELECT * FROM EMT_PUBLICATION_CATEGORY
               " . (count($joins) ? implode(' ', $joins) : '') . " 
               " . (count($wheres) ? '('.implode(') AND (', $wheres) . ')' : '') . "
               ORDER BY " . ($this->sort == 'id' ? 'ID' : myTools::NLSFunc($sortFields[$this->sort], 'SORT')) . " {$this->dir}
               ";
        $this->pager = PublicationCategoryPeer::getPager($this->page, $this->ipp, $sql);
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