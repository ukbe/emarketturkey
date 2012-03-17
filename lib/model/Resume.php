<?php

class Resume extends BaseResume
{
    private $licenseStr = "";
    
    public function getDisplayedTimes()
    {
        return 3;
    }
    
    public function getStatusArray($item_index = null)
    {
        $status = array('1' => array('layout/success-15.gif', 'Active', 'Deactivate'),
                         '' => array('layout/fail-15.gif', 'Passive', 'Activate'));
        if (isset($item_index))
        {
            return $status[$this->getActive()][$item_index];
        }
        return $status[$this->getActive()];
    }
    
    public function getSchool($sid)
    {
        $c = new Criteria();
        $c->add(ResumeSchoolPeer::ID, $sid);
        $arr = $this->getResumeSchools($c);
        return count($arr)?$arr[0]:null;
    }

    public function getWork($sid)
    {
        $c = new Criteria();
        $c->add(ResumeWorkPeer::ID, $sid);
        $arr = $this->getResumeWorks($c);
        return count($arr)?$arr[0]:null;
    }

    public function getCourse($sid)
    {
        $c = new Criteria();
        $c->add(ResumeCoursePeer::ID, $sid);
        $arr = $this->getResumeCourses($c);
        return count($arr)?$arr[0]:null;
    }

    public function getLanguage($sid)
    {
        $c = new Criteria();
        $c->add(ResumeLanguagePeer::ID, $sid);
        $arr = $this->getResumeLanguages($c);
        return count($arr)?$arr[0]:null;
    }
    
    public function getSkill($sid)
    {
        $c = new Criteria();
        $c->add(ResumeSkillPeer::SKILL_ITEM_ID, $sid);
        $arr = $this->getResumeSkills($c);
        return count($arr)?$arr[0]:null;
    }
    
    public function getPublication($sid)
    {
        $c = new Criteria();
        $c->add(ResumePublicationPeer::ID, $sid);
        $arr = $this->getResumePublications($c);
        return count($arr)?$arr[0]:null;
    }
    
    public function getAward($sid)
    {
        $c = new Criteria();
        $c->add(ResumeAwardPeer::ID, $sid);
        $arr = $this->getResumeAwards($c);
        return count($arr)?$arr[0]:null;
    }
    
    public function getReference($sid)
    {
        $c = new Criteria();
        $c->add(ResumeReferencePeer::ID, $sid);
        $arr = $this->getResumeReferences($c);
        return count($arr)?$arr[0]:null;
    }
    
    public function getOrganisation($sid)
    {
        $c = new Criteria();
        $c->add(ResumeOrganisationPeer::ID, $sid);
        $arr = $this->getResumeOrganisations($c);
        return count($arr)?$arr[0]:null;
    }
    
    public function setSkill($skill_id, $proficiency_id)
    {
        $skill = $this->getSkill($skill_id);
        try
        {
            if (!$skill && $proficiency_id!=ProficiencyPeer::PRO_TYP_NO_EXPERIENCE)
            {
                $skill = new ResumeSkill();
                $skill->setResumeId($this->id);
                $skill->setSkillItemId($skill_id);
                $skill->setProficiencyId($proficiency_id);
                $skill->save();
            }
            elseif (!$skill && $proficiency_id == ProficiencyPeer::PRO_TYP_NO_EXPERIENCE)
            {
                // Do Nothing
            }
            else
            {
                // if proficiency = noExperience then delete the record
                if ($proficiency_id==ProficiencyPeer::PRO_TYP_NO_EXPERIENCE) $skill->delete();
                else
                {
                    $skill->setProficiencyId($proficiency_id);
                    if ($skill->isModified()) $skill->save();
                }
            }
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
    
    public function getSkillList()
    {
        $c = new Criteria();
        $c->addJoin(ResumeSkillPeer::SKILL_ITEM_ID, SkillInventoryItemPeer::ID, Criteria::LEFT_JOIN);

        $c->addJoin(SkillInventoryItemPeer::CATEGORY_ID, SkillCategoryPeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(SkillCategoryPeer::ID, SkillCategoryI18nPeer::ID, Criteria::LEFT_JOIN);
        $c->add(SkillCategoryI18nPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());
        $c->addAscendingOrderByColumn(SkillCategoryI18nPeer::NAME);

        $c->addJoin(SkillInventoryItemPeer::ID, SkillInventoryItemI18nPeer::ID, Criteria::LEFT_JOIN);
        $c->add(SkillInventoryItemI18nPeer::CULTURE, sfContext::getInstance()->getUser()->getCulture());
        $c->addAscendingOrderByColumn(SkillInventoryItemI18nPeer::NAME);
        
        $c->addJoin(ResumeSkillPeer::PROFICIENCY_ID, ProficiencyPeer::ID, Criteria::LEFT_JOIN);

        $c->add(ResumeSkillPeer::RESUME_ID, $this->id);
        
        return ResumeSkillPeer::doSelect($c);
    }
    
    public function setLicense($pos, $value)
    {
        if (strlen($this->licenseStr) < ($pos+1))
        {
            $this->licenseStr = str_repeat('0', $pos+1-strlen($this->licenseStr)).$this->licenseStr;
        }
        $this->licenseStr{strlen($this->licenseStr)-$pos-1} = ($value=='1'?'1':'0');
        $this->setDriversLicense(bindec($this->licenseStr));
    }
    
    public function getLicense($pos)
    {
        $this->licenseStr = decbin($this->drivers_license);
        if (strlen($this->licenseStr) < ($pos+1))
        {
            $this->licenseStr = str_repeat('0', $pos+1-strlen($this->licenseStr)).$this->licenseStr;
        }
        return $this->licenseStr{strlen($this->licenseStr)-1-$pos};
    }
    
    public function getItems($type, $id = null)
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::OWNER_ID, $this->getUserId());
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(MediaItemPeer::ITEM_TYPE_ID, $type);
        if ($id) $c->add(MediaItemPeer::ID, $id);
        return isset($id) ? MediaItemPeer::doSelectOne($c) : MediaItemPeer::doSelect($c);
    }
    
    public function getPhotoUri($size = MediaItemPeer::LOGO_TYP_SMALL)
    {
        $ppic = $this->getPhoto();
        $parray = array(MediaItemPeer::LOGO_TYP_SMALL     => "content/user/profile/S",
                      MediaItemPeer::LOGO_TYPE_MEDIUM   => "content/user/profile/M",
                      MediaItemPeer::LOGO_TYPE_LARGE    => "content/user/profile"
                );
        $path = $parray[$size];
        $gender = $this->getUser()->getGender()===UserProfilePeer::GENDER_FEMALE ? 'female' : 'male';
        if ($ppic)
        {
            switch ($size)
            {
                case MediaItemPeer::LOGO_TYPE_MEDIUM :
                    return file_exists($ppic->getMediumPath()) ? $ppic->getMediumUri() : "$path/no_photo_{$gender}_not_found.jpg";
                    break;
                case MediaItemPeer::LOGO_TYPE_LARGE :
                    return file_exists($ppic->getPath()) ? $ppic->getUri() : "$path/no_photo_{$gender}_not_found.jpg";
                    break;
                case MediaItemPeer::LOGO_TYP_SMALL :
                default: 
                    return file_exists($ppic->getThumbnailPath()) ? $ppic->getThumbnailUri() : "$path/no_photo_{$gender}_not_found.jpg";
                    break;
            }
        }
        else
        {
            return "$path/no_photo_{$gender}.jpg";
        }
    }
    
    public function getPhoto()
    {
        $photos = $this->getItems(MediaItemPeer::MI_TYP_RESUME_PHOTO);
        return count($photos)?$photos[0]:null;;
    }
    
    public function getHardCopyCV()
    {
        $hccvs = $this->getItems(MediaItemPeer::MI_TYP_HARDCOPY_CV);
        return count($hccvs)?$hccvs[0]:null;
    }
    
    public function getPortfolio($id = null)
    {
        return $this->getItems(MediaItemPeer::MI_TYP_RESUME_PORTFOLIO_ITEM, $id);
    }
    
    public function getVideoCV()
    {
        $vcvs = $this->getItems(MediaItemPeer::MI_TYP_VIDEO_CV);
        return count($vcvs)?$vcvs[0]:null;
    }
    
    public function getMissingInfoList()
    {
        $missingitems = array();
        if (!$this->getContact())
            $missingitems[] = array('Contact Information', '@mycv-action?action=contact');
        if (!$this->countResumeSchools())
            $missingitems[] = array('Education Status', '@mycv-action?action=education');
        if (!$this->countResumeWorks())
            $missingitems[] = array('Work Experience', '@mycv-action?action=work');
        if (!$this->countResumeCourses())
            $missingitems[] = array('Courses & Certificates', '@mycv-action?action=courses');
        if (!$this->countResumeLanguages())
            $missingitems[] = array('Languages', '@mycv-action?action=languages');
        if (!$this->countResumeSkills())
            $missingitems[] = array('Expertise and Skills', '@mycv-action?action=skills');
        if (!$this->countResumePublications())
            $missingitems[] = array('Publications', '@mycv-action?action=publications');
        if (!$this->countResumeAwards())
            $missingitems[] = array('Awards', '@mycv-action?action=awards');
        if (!$this->countResumeReferences())
            $missingitems[] = array('References', '@mycv-action?action=references');
        if (!$this->countResumeOrganisations())
            $missingitems[] = array('Organisations', '@mycv-action?action=organisations');
        if (!$this->getHardCopyCV())
            $missingitems[] = array('Hardcopy CV', '@mycv-action?action=materials');
        if (!$this->getPhoto())
            $missingitems[] = array('Photo', '@mycv-action?action=materials');
        return $missingitems;
    }

    public function getOwner()
    {
        return $this->getUser();
    }
    
    public function getDefineText($to_user, $culture)
    {
        $owner = $this->getOwner();

        $i18n = sfContext::getInstance()->getI18N();
        $cl = $i18n->getCulture();
        $i18n->setCulture($culture);

        $result = "a resume";
        
        $result = $is_owner ? $i18n->__("your resume") : $i18n->__("%1u's resume", array('%1u' => $owner));

        $i18n->setCulture($cl);
        return $result;
    }
    
    public function getFolderFor($hr_profile_id, $return_classify = false)
    {
        $c = new Criteria();
        $c->addJoin(ClassifiedResumePeer::FOLDER_ID, ResumeFolderPeer::ID);
        $c->add(ResumeFolderPeer::HR_PROFILE_ID, $hr_profile_id);
        $classify = $this->getClassifiedResumes($c);
        return count($classify) ? ($return_classify ? $classify[0] : $classify[0]->getResumeFolder()) : null;
    }

    public function getFolderIdFor($hr_profile_id)
    {
        return ($folder = $this->getFolderFor($hr_profile_id)) ? $folder->getId() : null;
    }

    public function getClassification($hr_profile_id)
    {
        return $this->getFolderFor($hr_profile_id, true);
    }
    
    public function getChannels($hr_profile_id)
    {
        $channels = array();

        $c = new Criteria();
        $c->add(DatabaseCVPeer::HR_PROFILE_ID, $hr_profile_id);
        $c->add(DatabaseCVPeer::CHANNEL_TYPE_ID, DatabaseCVPeer::CHANNEL_SERVICE);
        if (count($results = $this->getDatabaseCVs($c))) $channels[DatabaseCVPeer::CHANNEL_SERVICE] = $results;

        $c = new Criteria();
        $c->addJoin(UserJobPeer::JOB_ID, JobPeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(JobPeer::OWNER_ID, HRProfilePeer::OWNER_ID, Criteria::LEFT_JOIN);
        $c->add(HRProfilePeer::OWNER_TYPE_ID, HRProfilePeer::OWNER_TYPE_ID."=".JobPeer::OWNER_TYPE_ID, Criteria::CUSTOM);
        $c->add(HRProfilePeer::ID, $hr_profile_id);
        $c->add(UserJobPeer::TYPE_ID, UserJobPeer::UJTYP_APPLIED);
        if (count($results = $this->getUser()->getUserJobs($c))) $channels[DatabaseCVPeer::CHANNEL_APPLICATION] = $results;
        
        // Add channel info for referral signup;
        
        return $channels;
    }
    
    public function getAddressByTypeId($type_id)
    {
        return $this->getContact() ? $this->getContact()->getAddressByType($type_id) : null;
    }
    
    public function getPhoneByTypeId($type_id)
    {
        return $this->getContact() ? $this->getContact()->getPhoneByType($type_id) : null;
    }
    
}

