<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class indexAction extends EmtAction
{
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->friends = $this->sesuser->getFriends(null);
        $this->groups = $this->sesuser->getGroups();
        $this->companies = $this->sesuser->getCompanies();
        $this->req_count = $this->sesuser->getRequestCount();
        $this->tab = $this->getRequestParameter('tab');
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