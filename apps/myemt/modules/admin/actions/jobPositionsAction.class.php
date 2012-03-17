<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class jobPositionsAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();

        $table = new EmtAjaxTable('jobpositions');
        $table->init();

        $this->table = $table;
        
        if ($this->getRequestParameter('act') == 'ret')
        {
            $this->setTemplate('retrieveJobPositions');
            $this->setLayout(false);
        }
        
        return sfView::SUCCESS;
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