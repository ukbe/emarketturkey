<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class activityAction extends EmtAction
{
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->activities = $this->sesuser->getNetworkActivity(); 
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