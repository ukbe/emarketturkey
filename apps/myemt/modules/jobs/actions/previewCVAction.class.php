<?php

class previewCVAction extends EmtManageJobAction
{
    public function handleAction($isValidationError)
    {
        if (preg_match("/\d+/", $this->getRequestParameter('appid')))
            $this->app = $this->job->getApplicant($this->getRequestParameter('appid'));
        else $this->app = null;

        if (!$this->app) $this->redirect404();
        
        $this->profile = $this->owner->getHRProfile();
        $this->resume = $this->app->getUser()->getResume();
        if (!$this->resume)
        {
            $this->setTemplate('missingCV');
            $this->folder = null;
        }
        else {
            $this->folder = $this->resume->getFolderFor($this->profile->getId());
        }
        
        switch ($this->getRequestParameter('act'))
        {
            case "chgstatus" :
                $this->status_id = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('status_id')), array_keys(UserJobPeer::$statusLabels));
                if ($this->status_id !== null)
                {
                    if ($this->getRequestParameter('do') == 'commit')
                    {
                        $this->app->setStatus($this->status_id, $this->getRequestParameter('notify'), $this->getRequestParameter('template_id'));
                    }
                    else
                    {
                        $this->templates = $this->profile->getMessageTemplateByType($this->status_id, true, false);
                        $this->template = $this->profile->getMessageTemplateByType($this->status_id, true);
                        $this->setTemplate('changeAppStatus');
                    }
                }
                break;
            case "classify" :
                if (!$this->resume) break;
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

        if (!$this->app->getEmployerRead())
        {
            $this->app->setEmployerRead(1);
            $this->app->save();
        }

        $keyword = $this->getUser()->getAttribute('keyword', null, '/myemt/jobs/applicants/browse');
        $status = $this->getUser()->getAttribute('status', null, '/myemt/jobs/applicants/browse');
        $this->prevnext = $this->job->getPrevNextOfApp($this->app->getId(), $status, $keyword);
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