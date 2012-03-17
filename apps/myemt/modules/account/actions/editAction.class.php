<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class editAction extends EmtAction
{

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
        
        $this->user = $this->getUser()->getUser();
        $this->login = $this->user->getLogin();
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
                $this->user->setName($this->getRequestParameter('user_name'));
                $this->user->setLastname($this->getRequestParameter('user_lastname'));
                $this->user->setAlternativeEmail($this->getRequestParameter('user_alternative_email'));
                if ($this->user->isModified())
                {
                    $this->user->save();
                    ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_UPDATE_PERSONAL_INFO);
                }
                if (!$this->login->hasUsername()) $this->login->setUsername($this->getRequestParameter('user_username'));
                if ($this->login->isModified())
                {
                    $this->login->save();
                    ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_SET_USERNAME);
                }
                $this->redirect('account/index');
            }
        }
    }

    public function validate()
    {
        if ($this->getRequestParameter('user_username') == $this->login->getUsername())
            $this->getRequest()->removeError('user_username');
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}