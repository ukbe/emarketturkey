<?php

class EmtAuthorAction extends EmtManageAction
{
    protected $forceAuthor = true;

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->author = $this->sesuser->getAuthor();
        
        if (!$this->author && $this->forceAuthor && !$this->sesuser->isNew())
        {
            $this->forward404("You don't have enough credentials.");
        }
    }

}