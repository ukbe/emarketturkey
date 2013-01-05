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
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.company-profile-action?".http_build_query($params), 301);

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