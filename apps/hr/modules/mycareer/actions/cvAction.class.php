<?php

class cvAction extends EmtAction
{
    public function execute($request)
    {
        $this->resume = $this->getUser()->getUser()->getResume();
    }
    
    public function handleError()
    {
    }
    
}
