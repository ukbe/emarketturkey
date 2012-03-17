<?php

class EmtManageProductAction extends EmtManageCompanyAction
{
    protected $enforceProduct = true;
    
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->product = ProductPeer::getProductFromUrl($this->getRequest()->getParameterHolder(), $this->company);

        if ($this->enforceProduct && !$this->product) $this->redirect404();
        
        if ($this->product && !$this->company->getProduct($this->product->getId()))
        {
            $this->redirect('@homepage');
        }
        
    }
    
}