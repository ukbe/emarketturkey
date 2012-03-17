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
        $this->redirect('@cm.requests');
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