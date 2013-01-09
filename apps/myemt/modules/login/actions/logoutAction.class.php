<?php

class logoutAction extends EmtAction
{
    public function execute($request)
    {
        $this->getUser()->signout();
        $this->redirect('@camp.homepage');
    }
    
}
