<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class easyLoginAction extends EmtAction
{
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    public function initialize($context, $moduleName, $actionName)
    {
        if (!parent::initialize($context, $moduleName, $actionName))
        {
            return false;
        }
        return true;
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->getUser()->isAuthenticated())
        {
            $this->redirect('@homepage');
        }
        
        $this->getRequest()->getParameterHolder()->set('referer', $this->getRequest()->getReferer());
        
        if ($this->getRequest()->getMethod() != sfRequest::POST)
        {
            // display the form
            return sfView::SUCCESS;
        }
        else
        {
            if (!$isValidationError){
                // handle the form submission
                $c = new Criteria();
                $c->add(LoginPeer::EMAIL, $this->getRequestParameter('email'));
                $login = LoginPeer::doSelectOne($c);
                if (!$this->getUser()->signIn($login, $this->getRequestParameter('remember')))
                {
                    $this->blockeduser = $login->getUser();
                    $this->setTemplate('blockedAccount');
                    return sfView::SUCCESS;
                }
                
                // redirect to mymemt homepage or recent page
                if ($this->getRequestParameter('stack') !== 'A10' && $this->_ref=='')
                {
                    $this->redirect('@homepage');
                }

                if ($this->_ref != '') $this->redirect($this->_ref);
                $this->redirect('@homepage');
            }
            else{
                return sfView::SUCCESS;
            }
        }
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