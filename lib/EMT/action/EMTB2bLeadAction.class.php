<?php

class EmtB2bLeadAction extends EmtAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->lead = B2bLeadPeer::getLeadFromUrl($this->getRequest()->getParameterHolder());
        
        $this->forward404unless($this->lead);

        $this->company = $this->lead->getCompany();
    }
    
}