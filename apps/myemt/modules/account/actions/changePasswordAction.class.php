<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class changePasswordAction extends EmtAction
{
    
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
        
        $this->login = $this->getUser()->getLogin();
    }
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                $this->login->setPassword($this->getRequestParameter('new_pass'));
                $this->login->save();
                
                ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_CHANGE_PASSWORD);
                
                $this->getUser()->setMessage(null, 'Password was changed successfully!');

                $this->redirect('@account');
            }
        }
    }

    public function validate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$this->login->checkPassword($this->getRequestParameter('old_pass', '%NO_BLANK%')))
            {
                $this->getRequest()->setError('old_pass', 'Please type your old password correctly.');
            }
            else
            {
                $this->getRequest()->removeError('old_pass');
            }
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}