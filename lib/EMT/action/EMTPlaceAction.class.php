<?php

class EmtPlaceAction extends EmtAction
{

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->place = PlacePeer::getPlaceFromUrl($this->getRequest()->getParameterHolder());
        
        $this->forward404Unless($this->place);

    }
    
}
