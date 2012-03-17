<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        //if (!$this->sesuser->getUserProfile()) $this->redirect('default/setupProfile');
        
        $this->companies = $this->sesuser->getCompanies(RolePeer::RL_CM_OWNER);
        $this->groups = $this->sesuser->getGroups(RolePeer::RL_GP_OWNER);
        $this->activities = $this->sesuser->getNetworkActivity();
        
    }
    
    public function handleError()
    {
    }
    
}
