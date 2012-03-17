<?php

class EmtCVAction extends EmtAction
{
    protected $forceResume = false;

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->resume = $this->sesuser->getResume();
        
        if (!$this->resume && $this->forceResume)
        {
            $this->forward404('Requested CV could not be found.');
        }
    }

}