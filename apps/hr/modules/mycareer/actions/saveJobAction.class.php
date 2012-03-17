<?php

class saveJobAction extends EmtAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();
        
        if (!$this->user) $this->redirect404();
        
        if ($this->hasRequestParameter('id'))
        {
            $this->job = JobPeer::retrieveByGuid($this->getRequestParameter('id'));
            if (!$this->job || $this->job->getStatus()!=JobPeer::JSTYP_ONLINE) $this->redirect404();
            
            if (!$this->user->getUserJob($this->job->getId(), UserJobPeer::UJTYP_FAVOURITE))
            {
                $uj = new UserJob();
                $uj->setUserId($this->user->getId());
                $uj->setJobId($this->job->getId());
                $uj->setTypeId(UserJobPeer::UJTYP_FAVOURITE);
                $uj->save();
            }
            $this->redirect('@favourite-jobs');
        }
        else
        {
            $this->redirect('mycareer/index');
        }
    }
    
    public function handleError()
    {
    }
    
}