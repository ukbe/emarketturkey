<?php

class vaultCVAction extends EmtManageJobAction
{
    protected $enforceJob = false;
    
    public function handleAction($isValidationError)
    {
        $this->profile = $this->owner->getHRProfile();
        
        if (preg_match("/\d+/", $this->getRequestParameter('rid')))
            $this->resume = $this->profile->findVaultCV($this->getRequestParameter('rid'));
        else $this->resume = null;

        if (!$this->resume) $this->redirect404();
        
        $this->folder = $this->resume->getFolderFor($this->profile->getId());
        $this->channels = $this->resume->getChannels($this->profile->getId());
        
        switch ($this->getRequestParameter('act'))
        {
            case "chgstatus" :
                break;
            case "classify" :
                if (preg_match("/\d+/", $this->getRequestParameter('folder_id')) && $this->profile)
                {
                    $folder = $this->profile->getFolderById($this->getRequestParameter('folder_id'));
                }
                elseif ($this->getRequestParameter('folder_id') == 'new' && $this->profile)
                {
                    if ($this->profile->countResumeFolders() < (($conf = sfConfig::get('app_jobs_profileconf')) && isset($conf['max_folder_count']) ? $conf['max_folder_count'] : 10))
                        $folder = $this->profile->createFolder($this->getRequestParameter('folder_name'));
                    else
                        $folder = null;
                }
                if (isset($folder) && $folder)
                {
                    $current = $this->resume->getClassification($this->profile->getId());
                    if ($current)
                    {
                        $current->setFolderId($folder->getId());
                        $current->save();
                    }
                    else
                    {
                        $new = new ClassifiedResume();
                        $new->setFolderId($folder->getId());
                        $new->setResumeId($this->resume->getId());
                        $new->save();
                    }
                    $this->folder = $folder;
                }
                break;
            case "ignore" : 
                break;
            case "fav" : 
                break;
            case "unflag" :
                break;
        }

        $this->keyword = $this->getUser()->getAttribute('keyword', null, '/myemt/jobs/cvvault/browse');
        $this->channel = $this->getUser()->getAttribute('channel', null, '/myemt/jobs/cvvault/browse');
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {   
    }
}