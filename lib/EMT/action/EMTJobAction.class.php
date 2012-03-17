<?php

class EmtJobAction extends EmtAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->job = JobPeer::getJobFromUrl($this->getRequest()->getParameterHolder());

        $this->forward404unless($this->job);
        
        $this->owner = $this->job->getOwner();
        $this->otyp = $this->job->getOwnerTypeId();
        
        $this->own = $this->owner->getHash();
        
        $this->ownerroute = ($this->otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "@company-jobs?hash={$this->own}" : "@group-jobs?hash={$this->own}");
        $this->jobroute = $this->job ? "@job?guid={$this->job->getGuid()}" : null;
    }
    
}
