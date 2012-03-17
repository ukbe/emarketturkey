<?php

class indexAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $params = array();
        $params[] = ($this->hasRequestParameter('invite') ? "invite={$this->getRequestParameter('invite')}" : "");
        $params[] = ($this->hasRequestParameter('keepon') ? "keepon={$this->getRequestParameter('keepon')}" : "");
        $this->redirect('@myemt.signup' . (count($params) ? '?' . implode('&', $params) : ''));
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