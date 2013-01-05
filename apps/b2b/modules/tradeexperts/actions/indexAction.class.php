<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect("@camp.tradeexperts", 301);

    }
    
    public function handleError()
    {
    }
    
}
