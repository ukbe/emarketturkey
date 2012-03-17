<?php

class EmtEventAction extends EmtAction
{

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->event = EventPeer::getEventFromUrl($this->getRequest()->getParameterHolder(), true);
        
        $this->forward404Unless($this->event);

    }
    
}
