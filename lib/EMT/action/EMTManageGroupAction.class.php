<?php

class EmtManageGroupAction extends EmtManageAction
{
    protected $actionID = null;

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->group = GroupPeer::getGroupFromUrl($this->getRequest()->getParameterHolder());
        
        if (!$this->group) $this->redirect404();
        
        if (!$this->sesuser->isNew() && !$this->sesuser->getGroup($this->group->getId()))
        {
            $this->redirect('@homepage');
        }
        
        $this->goodToRun = $this->actionID ? $this->sesuser->can($this->actionID, $this->group) : null;
    }
    
}

