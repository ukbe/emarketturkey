<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class platformAdsAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $table = new EmtAjaxTable('platformads');
        $table->init();
        $this->table = $table;
        
        if ($this->getRequestParameter('act') == 'ret')
        {
            $this->setTemplate('retrievePlatformAds');
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