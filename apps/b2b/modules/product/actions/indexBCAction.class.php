<?php

class indexBCAction extends EmtAction
{
    public function execute($request)
    {
        if ($this->getRequestParameter('id') < 969)
        {
            $product = ProductPeer::retrieveByPK($this->getRequestParameter('id'));
            
            if ($product && $product->getCompany())
            {
                $this->redirect($product->getUrl(), 301);
            }
        }
        $this->redirect404();
    }
    
    public function handleError()
    {
    }
    
}