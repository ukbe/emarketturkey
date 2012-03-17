<?php

class indexAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->cart = $this->sesuser->getCart();
        
    }
    
    public function handleError()
    {
    }
    
}