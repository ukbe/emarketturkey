<?php

class cvAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['action']);
        unset($params['sf_culture']);
        $this->redirect("@camp.mycv-action?".http_build_query($params), 301);

        $this->resume = $this->getUser()->getUser()->getResume();
    }
    
    public function handleError()
    {
    }
    
}
