<?php

class EmtAjaxAction extends EmtAction
{
    CONST DB_CREATE     = 1;
    CONST DB_CREATED    = 2;
    CONST DB_EDIT       = 3;
    CONST DB_UPDATE     = 4;
    CONST DB_UPDATED    = 5;
    CONST DB_REVIEW     = 6;
    CONST DB_QUIT       = 7;
    CONST DB_DELETE     = 8;
    CONST DB_DELETED    = 9;
    
    public $ajState;
    
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        if ($this->isSecure() && !$this->getUser()->isAuthenticated())
            $this->redirect('login', 'login');
        
        // redirect to 404 if it is not an ajax request
        //if (!$this->getRequest()->isXmlHttpRequest())
        {
          //  $this->redirect404();
        }
        
        $this->login = $this->getUser()->getLogin();
        $this->ajState = 0;
        if ($this->login)
        {
            if ($this->getRequestParameter('credit', '') != $this->login->getGuid())
            {
                return false;
            }
        }
        //retrieve 
        $this->user = $this->getUser()->getUser();
        
        if (($this->getRequest()->getMethod() == sfRequest::GET) && ($this->getRequestParameter('act')=='rem')) $this->ajState = self::DB_DELETE;
        if (($this->getRequest()->getMethod() == sfRequest::GET) && ($this->getRequestParameter('act')=='edit')) $this->ajState = self::DB_EDIT;
        if (($this->getRequest()->getMethod() == sfRequest::GET) && ($this->getRequestParameter('act')!='rem') && ($this->getRequestParameter('act')!='edit')) $this->ajState = self::DB_REVIEW;
        if ($this->getRequest()->getMethod() == sfRequest::POST) $this->ajState = self::DB_UPDATE;
    }
    
    public function setState($state)
    {
        $this->ajState = $state;
        $this->setVar('ajState', $state);
    }

    public function setStateIf($cond, $state)
    {
        if ($this->ajState == $cond){
            $this->setState($state);
        }
    }

    public function setStateUnless($cond, $state)
    {
        if ($this->ajState != $cond){
            $this->setState($state);
        }
    }

    public function setStateIfElse($cond, $state, $otherwise)
    {
        if ($this->ajState == $cond){
            $this->setState($state);
        } else {
            $this->setState($otherwise);
        }
    }
    
    public function selectTemplate()
    {
        if ($this->ajState == self::DB_CREATE || $this->ajState == self::DB_EDIT || $this->ajState == self::DB_UPDATE){
            $this->setTemplate($this->getActionName());
        } else if ($this->ajState == self::DB_CREATED || $this->ajState == self::DB_UPDATED || $this->ajState == self::DB_REVIEW) {
            $this->setTemplate($this->getActionName().'Display');
        }
    }
}

