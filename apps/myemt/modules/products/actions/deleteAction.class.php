<?php

class deleteAction extends EmtManageProductAction
{
    public function execute($request)
    {
        if (md5($this->product->getName().$this->product->getId().session_id())==$this->getRequestParameter('do'))
        {
            $this->product->delete();
        }
        $this->redirect("@manage-products?hash={$this->company->getId()}");
    }
    
    public function handleError()
    {
    }
    
}