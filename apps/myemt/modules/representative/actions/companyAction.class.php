<?php

class companyAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->company = CompanyPeer::retrieveByPK($this->getRequestParameter('id'));
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Company Details: %1', array('%1' => $this->company->getName())));
        }
        else
        {
            $this->getUser()->setMessage('Company could not be found!', 'Please click the company from the list to display its details');
            $this->redirect('representative/companies');
        }
        
        if ($this->getRequestParameter('act') == 'rem')
        {
            $this->company->delete();
            $this->redirect('representative/companies');
        }
        
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {   
        return !$this->getRequest()->hasErrors();
    }
}
