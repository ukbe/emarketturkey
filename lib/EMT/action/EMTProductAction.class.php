<?php

class EmtProductAction extends EmtCompanyAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->product = ProductPeer::getProductFromUrl($this->getRequest()->getParameterHolder(), $this->company, true);
        
        $this->forward404unless($this->product);

        $this->groups = $this->company->getOrderedGroups(false);
        
        $this->getResponse()->addMeta('description', $this->product->getIntroduction());

        
    }
    
}