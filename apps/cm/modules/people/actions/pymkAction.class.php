<?php

class pymkAction extends EmtAction
{
    public function execute($request)
    {
        $this->page = myTools::fixInt($this->getRequestParameter('page', 1));
        $this->bookmark = myTools::fixInt($this->getRequestParameter('bookmark', null));
        if ($this->bookmark) $this->page = $this->bookmark+1;

        $this->pager = $this->sesuser->getSuggestedFriendsPager(3, false, 20, $this->page, true);

        if ($this->pager->getLastPage() < $this->page)
        {
            $this->pager->setMaxPerPage(0);
            $this->pager->init();
        }

        $this->page = $this->bookmark = ($this->page != $this->pager->getPage() ? 1 : $this->page);

        if ($this->getRequest()->isXmlHttpRequest())
        {
            sfLoader::loadHelpers('Partial');
            $content = get_partial('layout_extended', array('pager' => $this->pager, 'is_ajax' => true));
            return $this->renderText($this->getRequestParameter('callback').'('.json_encode(array('CONTENT' => $content, 'BOOKMARK' => $this->bookmark, 'ISLASTPAGE' => $this->pager->getLastPage()==$this->page, 'INITSCRIPT' => "window.initElementsScript('.data-table');")). ');');
        }

    }

    public function handleError()
    {
    }

}
