<?php

class byNameAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.companies-action?".http_build_query($params), 301);

    }

    public function handleError()
    {
    }

}
