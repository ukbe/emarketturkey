<?php

class EmtAction extends sfAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
        if (in_array($this->getRequestParameter('x-cult'), array('en', 'tr')))
        {
            $this->redirect(myTools::remove_querystring_var(myTools::localizedUrl($this->getRequestParameter('x-cult')), 'x-cult'));
        }

        // Creating default session user variable to handle rights
        if (!($this->sesuser = $this->getUser()->getUser())) 
        {
            $this->sesuser = new User();
        }

        if (!$this->sesuser->isNew() && $this->sesuser->isBlocked())
        {
            switch ($this->getContext()->getConfiguration()->getApplication() . '-' . 
                    $this->getModuleName() . '-' . 
                    $this->getActionName())
            {
                case "myemt-messages-compose" : 
                    $this->redirect('@verify-email');
                    break;
                case "cm-profile-add" : 
                    $this->redirect('@myemt.verify-email');
                    break;
                case "myemt-profile-add" : 
                    $this->redirect('@verify-email');
                    break;
            }
        }
        
        $this->userprops = $this->sesuser->getOwnerships();
        
        $this->refUrl = $this->getRequestParameter('ref')!='' ? urldecode($this->getRequestParameter('ref')) : null;
        $this->_referer = $this->getRequest()->getReferer() ? $this->getRequest()->getReferer() : null;
        
        $this->_ref = $this->getRequestParameter('_ref') ? urldecode($this->getRequestParameter('_ref')) : null;
        $this->_here = urlencode($this->getRequest()->getUri());
    }
    
    public function execute($request)
    {
    }
    
    protected function getDefaultModule()
    {
        return 'default';
    }
    
}

