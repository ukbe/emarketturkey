<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $this->net_products = $this->sesuser->getConnections(PrivacyNodeTypePeer::PR_NTYP_COMPANY, null, true, true, 5, true, null, null, null,PrivacyNodeTypePeer::PR_NTYP_PRODUCT);
        $this->spot_products = ProductPeer::getFeaturedProducts(5);
    }
    
    public function handleError()
    {
    }
    
}
