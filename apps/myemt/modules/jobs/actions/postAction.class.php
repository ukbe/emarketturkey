<?php

class postAction extends EmtManageJobAction
{
    protected $enforceJob = false;
    
    public function handleAction($isValidationError)
    {
        $this->hrprofile = $this->owner->getHRProfile();
        
        if (!$this->hrprofile)
        {
            $this->redirect("{$this->route}&action=profile&act=edit");
        }
        
        if ($this->job instanceof Job)
        {
            $this->redirect("{$this->route}&action=details&id={$this->job->getId()}");
        }
        else
        {
            $pitem = PurchasePeer::getProvisionFor($this->owner->getId(), $this->otyp, ServicePeer::STYP_JOB_ANNOUNCEMENT);
            
            if ($pitem)
            {
                $this->job = new Job();
                $this->job->setPurchaseItemId($pitem->getId());
            }
            else
            {
                $this->redirect("{$this->route}&action=plans");
            }
            
            $this->countries = array($this->owner->getContact()->getWorkAddress()->getCountry());
            $this->photos = array();
            $this->i18ns = array();
        }
        
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection();
    
            try
            {
                $con->beginTransaction();
                
                if ($this->job->isNew()) $this->job->setStatus(JobPeer::JSTYP_OFFLINE);
                $this->job->setOwnerId($this->owner->getId());
                $this->job->setOwnerTypeId($this->otyp);
                $this->job->setDefaultLang($this->getRequestParameter('job_lang_0'));
                $this->job->setTitle($this->getRequestParameter('job_title_0'));
                $this->job->setRefCode($this->getRequestParameter('job_refcode'));
                $this->job->setSallaryType($this->getRequestParameter('job_sallary_type'));
                $this->job->setSallaryStart($this->job->getSallaryType() == 1 ? $this->getRequestParameter('job_sallary_exact') : $this->getRequestParameter('job_sallary_start_span'));
                $this->job->setSallaryEnd($this->job->getSallaryType() == 1 ? null : $this->getRequestParameter('job_sallary_end_span'));
                $this->job->setSallaryCurrency($this->getRequestParameter('job_sallary_currency'));
                $this->job->save();
                $this->job->reload();

                $this->job->addSpec(JobSpecPeer::JSPTYP_JOB_FUNCTION, $this->getRequestParameter('job_function'), true);
                $this->job->addSpec(JobSpecPeer::JSPTYP_JOB_GRADE, $this->getRequestParameter('job_position_level'), true);
                $this->job->addSpec(JobSpecPeer::JSPTYP_WORKING_SCHEME, $this->getRequestParameter('job_working_scheme'), true);
                $this->job->addSpec(JobSpecPeer::JSPTYP_EXPERIENCE_YEAR, $this->getRequestParameter('job_experience'), true);

                foreach ($this->getRequestParameter('job_education_level') as $key => $enabled)
                {
                    if ($enabled) $this->job->addSpec(JobSpecPeer::JSPTYP_SCHOOL_DEGREE, $key, true); 
                }
                
                foreach ($this->getRequestParameter('job_special_case') as $type => $enabled)
                {
                    if ($enabled)
                    {
                        $this->job->addSpec(JobSpecPeer::JSPTYP_SPECIAL_CASE, $type);
                    }
                    else
                    {
                        $this->job->removeSpec(JobSpecPeer::JSPTYP_SPECIAL_CASE, $type);
                    }
                }
                
                $this->job->addSpec(JobSpecPeer::JSPTYP_SMOKING_STATUS, $this->getRequestParameter('job_smoker'));

                foreach ($this->getRequestParameter('job_dr_license') as $type => $enabled)
                {
                    if ($enabled)
                    {
                        $this->job->addSpec(JobSpecPeer::JSPTYP_DRIVERS_LICENSE, $type);
                    }
                    else
                    {
                        $this->job->removeSpec(JobSpecPeer::JSPTYP_DRIVERS_LICENSE, $type);
                    }
                }
                
                $this->job->addSpec(JobSpecPeer::JSPTYP_TRAVEL_PERCENT, $this->getRequestParameter('job_travel'));
                $this->job->addSpec(JobSpecPeer::JSPTYP_MILSERV_STATUS, $this->getRequestParameter('job_mservice'));
                if ($this->getRequestParameter('job_mservice') == 3)
                    $this->job->addSpec(JobSpecPeer::JSPTYP_MILSERV_POSTYEAR, $this->getRequestParameter('job_mservice') == 1 || $this->getRequestParameter('job_mservice') == 2 ? null : $this->getRequestParameter('job_mservice_numyear'));
                else
                    $this->job->removeSpec(JobSpecPeer::JSPTYP_MILSERV_POSTYEAR);
                
                /* 
                 * Temporarily commented out to trigger after job publication
                 * ActionLogPeer::Log($this->company, ActionPeer::ACT_POST_JOB, null, $this->job);
                 */

                $pr = $this->getRequestParameter('job_lang');
                $this->job->setDefaultLang($pr[0]);
                $this->job->save();

                if (is_array($pr))
                {
                    foreach($pr as $key => $lang)
                    {
                        if ($this->job->hasLsiIn($lang))
                        {
                            $sql = "UPDATE EMT_JOB_I18N 
                                    SET id=:id, culture=:culture, display_title=:display_title, description=:description, responsibility=:responsibility, requirements=:requirements, html=:html
                                    WHERE id=".$this->job->getId()." AND culture='$lang'
                            ";
                        }
                        else
                        {
                            $sql = "INSERT INTO EMT_JOB_I18N 
                                    (id, culture, display_title, description, responsibility, requirements, html)
                                    VALUES
                                    (:id, :culture, :display_title, :description, :responsibility, :requirements, :html)
                            ";
                        }
                        
                        $stmt = $con->prepare($sql);
                        $j_desc = $this->getRequestParameter("job_description_$key");
                        $j_resp = $this->getRequestParameter("job_responsibilities_$key");
                        $j_reqs = $this->getRequestParameter("job_requirements_$key");
                        $j_html = $this->getRequestParameter("html_$key");
                        $stmt->bindValue(':id', $this->job->getId());
                        $stmt->bindValue(':culture', $lang);
                        $stmt->bindValue(':display_title', $this->getRequestParameter("job_title_$key"));
                        $stmt->bindParam(':description', $j_desc, PDO::PARAM_STR, strlen($j_desc));
                        $stmt->bindParam(':responsibility', $j_resp, PDO::PARAM_STR, strlen($j_resp));
                        $stmt->bindParam(':requirements', $j_reqs, PDO::PARAM_STR, strlen($j_reqs));
                        $stmt->bindParam(':html', $j_html, PDO::PARAM_STR, strlen($j_html));
                        $stmt->execute();
                    }
                }
                if (!$this->job->isNew() && count($diff = array_diff($this->i18ns, $pr))) $this->job->removeI18n($diff);
                
                $locations = $this->job->getJobLocations();
                
                $countries = $this->getRequestParameter('job_country');
                
                foreach ($countries as $key => $country)
                {
                    if ($country != '')
                    {
                        if ($countries[$key] instanceof JobLocation)
                            $loc = $countries[$key];
                        else
                            $loc = new JobLocation();

                        $loc->setJobId($this->job->getId());
                        $loc->setCountryCode($country);
                        $loc->setLocationId($this->getRequestParameter("job_state_$key"));
                        $loc->setNoOfStaff($this->getRequestParameter("job_personel_$key"));
                        $loc->save();
                    }
                }
                
                $key++;
                
                for ($i = $key; $i < count($locations); $i++)
                {
                    $locations[$i]->delete();
                }
                
                $con->commit();
                
                $this->redirect("{$this->route}&action=addServices&job={$this->job->getGuid()}");
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new job information. Please try again later.', null, null, false);
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
        $pr = $this->getRequestParameter('job_lang');
        $pr = is_array($pr)?$pr:array();
        
        sfLoader::loadHelpers('I18n');
        
        foreach ($pr as $key => $lang)
        {
            $lang = trim($lang);
            if ($lang == '')
                $this->getRequest()->setError("job_lang_$key", __('Please select a language which you will provide job information in.'));
            if (trim($this->getRequestParameter("job_title_$key"))=='')
                $this->getRequest()->setError("job_title_$key", $lang ? __('Please enter job title for %1 language.', array('%1' => format_language($lang))) : __('Please enter job title.'));
            if (mb_strlen($this->getRequestParameter("job_title_$key")) > 255)
                $this->getRequest()->setError("job_title_$key", $lang ? __('Job title for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 255)) : __('Job title must be maximum %1 characters long.', array('%1' => 255)));
            if ($this->getRequestParameter("job_description_$key")=='')
                $this->getRequest()->setError("job_description_$key", $lang ? __('Please enter job description for %1 language.', array('%1' => format_language($lang))) : __('Please enter job description.'));
            if (mb_strlen($this->getRequestParameter("job_description_$key")) > 15000)
                $this->getRequest()->setError("job_description_$key", $lang ? __('Job description for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 15000)) : __('Job description must be maximum %1 characters long.', array('%1' => 15000)));
            if (mb_strlen($this->getRequestParameter("job_responsibilities_$key")) > 15000)
                $this->getRequest()->setError("job_responsibilities_$key", $lang ? __('Job resposibilities for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 15000)) : __('Job resposibilities must be maximum %1 characters long.', array('%1' => 15000)));
            if (mb_strlen($this->getRequestParameter("job_requirements_$key")) > 15000)
                $this->getRequest()->setError("job_requirements_$key", $lang ? __('Job requirements for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 15000)) : __('Job requirements must be maximum %1 characters long.', array('%1' => 15000)));
        }
        if ($this->getRequestParameter("job_sallary_type") == 1 && trim($this->getRequestParameter('job_sallary_exact')) == '')
            $this->getRequest()->setError("job_sallary_exact", __('Please enter sallary amount'));
        if ($this->getRequestParameter("job_sallary_type") == 2 && trim($this->getRequestParameter('job_sallary_start_span')) == '')
            $this->getRequest()->setError("job_sallary_start_span", __('Please enter lowest salary amount.'));
        if ($this->getRequestParameter("job_sallary_type") == 2 && trim($this->getRequestParameter('job_sallary_end_span')) == '')
            $this->getRequest()->setError("job_sallary_end_span", __('Please enter highest salary amount.'));
        if ($this->getRequestParameter("job_sallary_type") != '' && $this->getRequestParameter('job_sallary_currency') == '')
            $this->getRequest()->setError("job_sallary_currency", __('Please select sallary currency.'));

        return !$this->getRequest()->hasErrors();
    }
}