<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $params = array();
        $params[] = ($this->hasRequestParameter('invite') ? "invite={$this->getRequestParameter('invite')}" : "");
        $params[] = ($this->hasRequestParameter('keepon') ? "keepon={$this->getRequestParameter('keepon')}" : "");
        $this->redirect('@myemt.signup' . (count($params) ? '?' . implode('&', $params) : ''));
    }
    
}