<?php

class spotlightAction extends EmtAction
{
    public function execute($request)
    {
        $this->spot_products = ProductPeer::getFeaturedProducts(20);
    }

    public function handleError()
    {
    }

}
