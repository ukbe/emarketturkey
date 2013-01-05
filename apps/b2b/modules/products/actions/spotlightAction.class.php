<?php

class spotlightAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.products-action?".http_build_query($params), 301);

        $this->spot_products = ProductPeer::getFeaturedProducts(20);
    }

    public function handleError()
    {
    }

}
