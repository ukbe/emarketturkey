<?php

class postAction extends EmtManageJobsAction
{
    public function handleAction($isValidationError)
    {
        $this->hrprofile = $this->owner->getHRProfile();
        
        if (!$this->hrprofile)
        {
            $this->redirect($this->otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "@company-jobs-action?action=profile&hash={$this->own}" : "@group-jobs-action?action=profile&hash={$this->own}");
        }
        
        $this->onlinejobs = $this->owner->getOnlineJobs();
        $this->offlinejobs = $this->owner->getOfflineJobs();
                
        $this->cc = null;
        if (is_numeric($this->getRequestParameter('id')))
        {
            $job = $this->owner->getJob($this->getRequestParameter('id'));
            
            if (!$job) $this->redirect404();
            
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Job Posting: %1', array('%1' => $job->getTitle())));
            
            $this->locations = $job->getLocations();
        }
        else
        {
            $pits = $this->owner->getPurchaseItems(ServicePeer::STYP_JOB_ANNOUNCEMENT);
            
            $valid = false;
            $package_item = null;
            if (count($pits))
            {
                foreach ($pits as $pit)
                {
                    $mpi = $pit->getMarketingPackage()->getItemByServiceId(ServicePeer::STYP_JOB_ANNOUNCEMENT);

                    if (($mpi->getQuantity()>$this->owner->countJobsByPurchaseId($pit->getId())) &&
                        (($mpi->getTimeLimitTypeId()==1 && (mktime($pit->getCreatedAt('H'),$pit->getCreatedAt('i'),$pit->getCreatedAt('s'),$pit->getCreatedAt('n')+$mpi->getTimeLimit(),$pit->getCreatedAt('j'),$pit->getCreatedAt('Y')) > time())) ||
                        ($mpi->getTimeLimitTypeId()==2 && (mktime($pit->getCreatedAt('H'),$pit->getCreatedAt('i'),$pit->getCreatedAt('s'),$pit->getCreatedAt('n'),$pit->getCreatedAt('j'),$pit->getCreatedAt('Y')+$mpi->getTimeLimit()) > time())))
                        )                        
                    {
                        $valid = true;
                        $package_item = $pit;
                    }
                }
            }
            if ($valid && $package_item)
            {
                $job = new Job();
                $job->setPurchaseItemId($package_item->getId());
            }
            else
            {
                $this->redirect('service/packages?sid='.ServicePeer::STYP_JOB_ANNOUNCEMENT);
            }
            
            $this->locations = array();
        }
        
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection();
    
            try
            {
                $con->beginTransaction();
                
                $job->setCompanyId($this->company->getId());
                $job->setTitle($this->getRequestParameter('job_title'));
                $job->setRefCode($this->getRequestParameter('refcode'));
                $job->setSectorId($this->getRequestParameter('sector_id'));
                $job->setNoOfStaff($this->getRequestParameter('no_of_staff'));
                $job->setJobPositionId($this->getRequestParameter('position_id'));
                $job->setLocationId($this->getRequestParameter('location_id'));
                $job->save();
                
                ActionLogPeer::Log($this->company, ActionPeer::ACT_POST_JOB, null, $job);
                
                $pr = $this->getRequestParameter('languages');
                if (is_array($pr))
                {
                    foreach($pr as $lang)
                    {
                        if ($job->hasLsiIn($lang))
                        {
                            $sql = "UPDATE EMT_JOB_I18N 
                                    SET id=:id, culture=:culture, title_display_name=:title_display_name, html=:html, description=:description, requirements=:requirements, responsibility=:responsibility
                                    WHERE id=".$job->getId()." AND culture='$lang'
                            ";
                        }
                        else
                        {
                            $sql = "INSERT INTO EMT_JOB_I18N 
                                    (id, culture, title_display_name, html, description, requirements, responsibility)
                                    VALUES
                                    (:id, :culture, :title_display_name, :html, :description, :requirements, :responsibility)
                            ";
                        }
                        
                        $stmt = $con->prepare($sql);
                        $stmt->bindValue(':id', $job->getId());
                        $stmt->bindValue(':culture', $lang);
                        $stmt->bindValue(':title_display_name', $this->getRequestParameter('title_display_name_'.$lang));
                        $stmt->bindParam(':html', $this->getRequestParameter('html_'.$lang), PDO::PARAM_STR, strlen($this->getRequestParameter('html_'.$lang)));
                        $stmt->bindParam(':description', $this->getRequestParameter('description_'.$lang), PDO::PARAM_STR, strlen($this->getRequestParameter('description_'.$lang)));
                        $stmt->bindParam(':requirements', $this->getRequestParameter('requirements_'.$lang), PDO::PARAM_STR, strlen($this->getRequestParameter('requirements_'.$lang)));
                        $stmt->bindParam(':responsibility', $this->getRequestParameter('responsibility_'.$lang), PDO::PARAM_STR, strlen($this->getRequestParameter('responsibility_'.$lang)));
                        $stmt->execute();
                    }
                }

                $con->commit();
                $this->getUser()->setMessage('New Job Created!', 'New job was created successfully.', null, null, true);
                $this->redirect('jobs/list');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new job information. Please try again later.', null, null, false);
            }
        }
        
        $this->job = $job;
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
        /*$pr = $this->getRequestParameter('languages');
        $pr = is_array($pr)?$pr:array();
        
        foreach ($pr as $lang)
        {
            if ($this->getRequestParameter('title_display_name_'.$lang)=='')
                $this->getRequest()->setError('title_display_name_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter job title display name for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
            if ($this->getRequestParameter('description_'.$lang)=='')
                $this->getRequest()->setError('description_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter job description for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
            if ($this->getRequestParameter('html_'.$lang)=='')
                $this->getRequest()->setError('html_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter html content for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
            if ($this->getRequestParameter('requirements_'.$lang)=='')
                $this->getRequest()->setError('requirements_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter job requirements for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
        }
        */
        return !$this->getRequest()->hasErrors();
    }
}