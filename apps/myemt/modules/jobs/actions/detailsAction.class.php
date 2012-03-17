<?php

class detailsAction extends EmtManageJobAction
{
    protected $enforceJob = true;
    
    public function handleAction($isValidationError)
    {
        $this->hrprofile = $this->owner->getHRProfile();
        
        if (!$this->hrprofile)
        {
            $this->redirect("{$this->route}&action=profile&act=edit");
        }
        
        switch ($this->getRequestParameter('act'))
        {
            case "suspend" :
                if (in_array(JobPeer::JSTYP_SUSPENDED, $statSwap[$job->getStatus()]))
                {
                    //$this->job->
                }
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
                $this->app->setFlagType(UserJobPeer::UJ_EMPLYR_FLAG_IGNORE);
                $this->app->save();
                break;
            case "fav" : 
                $this->app->setFlagType(UserJobPeer::UJ_EMPLYR_FLAG_FAVOURITE);
                $this->app->save();
                break;
            case "unflag" :
                $this->app->setFlagType(0);
                $this->app->save();
                break;
        }
        
        $this->locations = $this->job->getJobLocations();
        $this->applicants = $this->job->getApplicants();
        $this->new_applicants = $this->job->getNewApplicants();
        //$this->photos = $this->job->getPhotos();
        $this->i18ns = $this->job->getExistingI18ns();
        
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection();
    
            try
            {
                $con->beginTransaction();

                $con->commit();
            }
            catch(Exception $e)
            {
                $con->rollBack();
            }
        }
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
        return !$this->getRequest()->hasErrors();
    }
}