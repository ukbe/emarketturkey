<?php

class EmtManageJobAction extends EmtManageAction
{
    protected $enforceJob = true;
    
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->otyp = (int)$this->getRequestParameter('otyp');

        switch ($this->otyp)
        {
            case PrivacyNodeTypePeer::PR_NTYP_COMPANY :
                $this->owner = CompanyPeer::getCompanyFromUrl($this->getRequest()->getParameterHolder());
                break;
            case PrivacyNodeTypePeer::PR_NTYP_GROUP :
                $this->owner = GroupPeer::getGroupFromUrl($this->getRequest()->getParameterHolder());
                break;
            default:
                $this->redirect404();
        }
        
        if (!$this->owner) $this->redirect404();

        $this->own = $this->owner->getHash();
        
        if (!$this->sesuser->isNew() && !$this->sesuser->isOwnerOf($this->owner)) $this->redirect404();
        
        $this->job = JobPeer::getJobFromUrl($this->getRequest()->getParameterHolder());
        if ($this->enforceJob && !$this->job) $this->redirect404();
        
        $this->route = ($this->otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "@company-jobs-action?hash={$this->own}" : "@group-jobs-action?hash={$this->own}");
        $this->jobroute = $this->job ? ($this->otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "@company-job-action?hash={$this->own}&guid={$this->job->getGuid()}" : "@group-job-action?hash={$this->own}&guid={$this->job->getGuid()}") : null;
    }
    
}
