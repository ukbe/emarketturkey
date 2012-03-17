<?php

class EmtManageCompanyEventAction extends EmtManageCompanyAction
{
    protected $enforceEvent = true;
    
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->event = EventPeer::getEventFromUrl($this->getRequest()->getParameterHolder(), $this->company);

        if ($this->enforceEvent && !$this->event) $this->redirect404();
        
        if ($this->event && !$this->company->getEvent($this->event->getId()))
        {
            $this->redirect('@homepage');
        }
    }
    
}