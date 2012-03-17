<?php

class toggleActivateAction extends EmtAjaxAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();
        $this->company = CompanyPeer::getCompanyFromUrl($this->getRequest()->getParameterHolder());
        if (!$this->company) return false;
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->product = $this->company->getProduct($this->getRequestParameter('id'));
            //if (!$this->product) return false;
            
            if (md5($this->product->getName().$this->product->getId().session_id())==$this->getRequestParameter('do'))
            {
                $this->product->setActive(!$this->product->getActive());
                $this->product->save();
            }
        }
        else return false;
    }
    
    public function handleError()
    {
    }
    
}