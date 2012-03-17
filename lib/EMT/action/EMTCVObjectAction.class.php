<?php

class EmtCVObjectAction extends EmtObjectHandlerAction
{
    protected $forceResume = false;

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
        
        $this->objowner = $this->resume = $this->sesuser->getResume();

        if (!$this->resume && $this->forceResume)
        {
            $this->forward404('Requested CV could not be found.');
        }
        
        $this->initObjectInterface();
    }

}