<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class networkAction extends EmtCompanyAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("%1 Network", array('%1' => $this->company->getName())) . ' | eMarketTurkey');
            
        $this->companies = $this->company->getCompanies();
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