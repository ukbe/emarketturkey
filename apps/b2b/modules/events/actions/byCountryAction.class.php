<?php

class byCountryAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.tradeshows-action?".http_build_query($params), 301);

        $this->countries = CountryPeer::getOrderedNames();
    }

    public function handleError()
    {
    }

}
