<?php

class EmtManageLeadAction extends EmtManageCompanyAction
{
    protected $enforceLead = true;
    
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->lead = B2bLeadPeer::getLeadFromUrl($this->getRequest()->getParameterHolder(), $this->company);

        if ($this->enforceLead && !$this->lead) $this->redirect404();
        
        if ($this->lead && !$this->company->getB2bLead($this->lead->getId()))
        {
            $this->redirect('@homepage');
        }
        
    }
    
}