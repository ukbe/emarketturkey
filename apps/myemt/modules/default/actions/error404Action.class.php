<?php

class error404Action extends EmtAction
{
    public function execute($request)
    {
        $this->getResponse()->setStatusCode(404);
    }
    
}
