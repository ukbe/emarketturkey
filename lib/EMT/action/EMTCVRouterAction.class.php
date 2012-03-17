<?php

class EmtCVRouterAction extends EmtRouterAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
        
        if ($this->isSecure() && !$this->getUser()->isAuthenticated())
            $this->forward('login', 'login');
        
        $this->user = $this->getUser()->getUser();
        $this->resume = $this->user->getResume();
        if (!$this->resume) $this->resume = new Resume();
            
        $this->latestAction = count($this->routingActions)-1;

        if ($this->getRequest()->getMethod() == sfRequest::POST && $this->hasRequestParameter('back_x'))
        {
            $this->redirectToPreviousAction();
        }
        
        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Editing: %1', array('%1' => $this->resume->getTitle())));
    }
    
    public function redirectToNextAction()
    {
        $this->updateLatestAction();
        $this->setDataInSession();
        $this->redirect($this->getModuleName().'/'.$this->routingActions[$this->getThisActionIndex()+1].'?id='.$this->resume->getId());
    }
    
    public function redirectToPreviousAction()
    {
        $this->latestAction = $this->getThisActionIndex() - 1;
        $this->setDataInSession();
        $this->redirect($this->getModuleName().'/'.$this->routingActions[$this->latestAction].'?id='.$this->resume->getId());
    }
    

}