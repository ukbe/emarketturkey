<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class pymkAction extends EmtManageAction
{
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $pg = $this->getRequestParameter('pg');
        $perpage = 20;
        $offset = $this->bookmark = (is_numeric($pg) ? $pg * $perpage : 0);
        $bookmark = myTools::fixInt($this->getRequestParameter('bookmark'));
        if ($bookmark) $offset = $this->boookmark = $bookmark;
//var_dump($this->bookmark);die;        
        $this->people = $this->sesuser->getFriendsToAdvise(2, $perpage, false, $offset);
        $count = $this->sesuser->countFriendsToAdvise(2);
        if ($offset > 0 && !count($this->people))
        {
            $offset = 0;
            $pg = 0;
            $this->people = $this->sesuser->getFriendsToAdvise(2, 20, false, $offset);
        }
        $this->nextPG = (($count > $offset + $perpage) ? $pg + 1 : null);
        $this->prevPG = ($pg > 0 ? $pg-1 : null);
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