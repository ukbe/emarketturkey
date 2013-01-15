<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $params = array();
        if ($this->hasRequestParameter('invite')) $params[] = "invite={$this->getRequestParameter('invite')}";
        if ($this->hasRequestParameter('keepon')) $params[] = "keepon={$this->getRequestParameter('keepon')}";
        $this->redirect('@myemt.signup' . (count($params) ? '?' . implode('&', $params) : ''));
    }
    
}