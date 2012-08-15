<?php

class HRProfile extends BaseHRProfile
{
    public function getHRLogo()
    {
        return $this->getImage(MediaItemPeer::MI_TYP_HR_LOGO);
    }

    public function getSpotBoxBackground()
    {
        return $this->getImage(MediaItemPeer::MI_TYP_JOB_SPOTBOX_BACK);
    }

    public function getPlatinumImage()
    {
        return $this->getImage(MediaItemPeer::MI_TYP_JOB_PLATINUM_IMAGE);
    }

    public function getRectBoxImage()
    {
        return $this->getImage(MediaItemPeer::MI_TYP_JOB_RECTBOX_IMAGE);
    }

    public function getCubeBoxImage()
    {
        return $this->getImage(MediaItemPeer::MI_TYP_JOB_CUBEBOX_IMAGE);
    }

    public function getImage($type_id)
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::ITEM_TYPE_ID, $type_id);
        $c->add(MediaItemPeer::OWNER_ID, $this->getOwnerId());
        $c->add(MediaItemPeer::OWNER_TYPE_ID, $this->getOwnerTypeId());
        return MediaItemPeer::doSelectOne($c);
    }
    
    public function getOwner()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getOwnerId(), $this->getOwnerTypeId());
    }
    
    public function getCVPreviewUrl($resume_id)
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . ($this->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "company-jobs-action?action=vaultCV&hash={$this->getOwner()->getHash()}&rid=$resume_id" : "group-jobs-action?action=vaultCV&hash={$this->getOwner()->getHash()}&rid=$resume_id");  
    }

    public function createFolder($folder_name)
    {
        if (!($folder =$this->getFolderByName($folder_name)))
        {
            $folder = new ResumeFolder();
            $folder->setHrProfileId($this->getId());
            $folder->setName($folder_name);
            $folder->save();
            return $folder;
        }
        return $folder;
    }
    
    public function getFolderById($folder_id)
    {
        $c = new Criteria();
        $c->add(ResumeFolderPeer::ID, $folder_id);
        $folders = $this->getResumeFolders($c);
        return $folder_id && count($folders) ? $folders[0] : null;
    }

    public function getFolderByName($folder_name)
    {
        $c = new Criteria();
        $c->add(ResumeFolderPeer::NAME, "UPPER(EMT_RESUME_FOLDER.NAME) = UPPER('$folder_name')", Criteria::CUSTOM);
        $folders = $this->getResumeFolders($c);
        return count($folders) ? $folders[0] : null;
    }
    
    public function getOrderedFolders()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(ResumeFolderPeer::NAME);
        $folders = $this->getResumeFolders();
        $arr = array();
        foreach($folders as $folder)
        {
            $arr[$folder->getId()] = $folder->getName();
        }
        return $arr;
    }

    public function getOrderedMessageTemplatesFor($type_id, $accept_builtin = true)
    {
/*
        $c = new Criteria();
        $cp = $c->getNewCriterion(JobMessageTemplatePeer::HR_PROFILE_ID, $this->getId());
        $cp->addOr($c->getNewCriterion(JobMessageTemplatePeer::HR_PROFILE_ID, "(HR_PROFILE_ID IS NULL AND NOT EXISTS (SELECT 1 FROM EMT_JOB_MESSAGE_TEMPLATE SECTAB WHERE EMT_JOB_MESSAGE_TEMPLATE.TYPE_ID=SECTAB.TYPE_ID AND SECTAB.HR_PROFILE_ID={$this->getId()}))", Criteria::CUSTOM));
        $c->addAnd($cp);
        $cp = $c->getNewCriterion(JobMessageTemplatePeer::TYPE_ID, $type_id);
        $cp->addOr($c->getNewCriterion(JobMessageTemplatePeer::TYPE_ID, null, Criteria::ISNULL));
        $c->addAnd($cp);
        $c->addAscendingOrderByColumn(JobMessageTemplatePeer::HR_PROFILE_ID);
        $c->addAscendingOrderByColumn(JobMessageTemplatePeer::ID);
        $c->setDistinct();
*/
        $templates = $this->getMessageTemplateByType($type_id, $accept_builtin, false);
        $arr = array();
        foreach($templates as $template)
        {
            $arr[$template->getId()] = $template->getName();
        }
        return $arr;
    }

    public function getMessageTemplatePager($page, $items_per_page = 20, $c1 = null, $status = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }

        switch ($status)
        {
            case UserJobPeer::UJ_STATUS_EVALUATING :
                $c->add(JobMessageTemplatePeer::TYPE_ID, UserJobPeer::UJ_STATUS_EVALUATING); 
                break;
            case UserJobPeer::UJ_STATUS_REJECTED :
                $c->add(JobMessageTemplatePeer::TYPE_ID, UserJobPeer::UJ_STATUS_REJECTED); 
                break;
            case UserJobPeer::UJ_STATUS_EMPLOYED :
                $c->add(JobMessageTemplatePeer::TYPE_ID, UserJobPeer::UJ_STATUS_EMPLOYED); 
                break;
        }
        $cp = $c->getNewCriterion(JobMessageTemplatePeer::HR_PROFILE_ID, $this->getId());
        $cp->addOr($c->getNewCriterion(JobMessageTemplatePeer::HR_PROFILE_ID, "(HR_PROFILE_ID IS NULL AND NOT EXISTS (SELECT 1 FROM EMT_JOB_MESSAGE_TEMPLATE SECTAB WHERE EMT_JOB_MESSAGE_TEMPLATE.TYPE_ID=SECTAB.TYPE_ID AND SECTAB.HR_PROFILE_ID={$this->getId()}))", Criteria::CUSTOM));
        $c->addAnd($cp);
        $c->addAscendingOrderByColumn(JobMessageTemplatePeer::HR_PROFILE_ID);
        $c->addAscendingOrderByColumn(JobMessageTemplatePeer::ID);
        $c->setDistinct();
        
        $pager = new sfPropelPager('JobMessageTemplate', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }
    
    public function getMessageTemplateById($id)
    {
        $c = new Criteria();
        $c->add(JobMessageTemplatePeer::ID, $id);
        $templates = $this->getJobMessageTemplates($c);
        return count($templates) ? $templates[0] : null;
    }
    
    public function getMessageTemplateByType($type_id, $accept_builtin = true, $single_row = true)
    {
        $c = new Criteria();
        if ($accept_builtin)
        {
            $cp = $c->getNewCriterion(JobMessageTemplatePeer::HR_PROFILE_ID, $this->getId());
            $cp->addOr($c->getNewCriterion(JobMessageTemplatePeer::HR_PROFILE_ID, "(HR_PROFILE_ID IS NULL AND NOT EXISTS (SELECT 1 FROM EMT_JOB_MESSAGE_TEMPLATE SECTAB WHERE EMT_JOB_MESSAGE_TEMPLATE.TYPE_ID=SECTAB.TYPE_ID AND SECTAB.HR_PROFILE_ID={$this->getId()}))", Criteria::CUSTOM));
            $c->addAnd($cp);
        }
        else
        {
            $c->add(JobMessageTemplatePeer::HR_PROFILE_ID, $this->getId());
        }
        $cp = $c->getNewCriterion(JobMessageTemplatePeer::TYPE_ID, $type_id);
        $cp->addOr($c->getNewCriterion(JobMessageTemplatePeer::TYPE_ID, 0));
        $c->addAnd($cp);
        
        $c->addAscendingOrderByColumn(JobMessageTemplatePeer::HR_PROFILE_ID);
        $c->addAscendingOrderByColumn(JobMessageTemplatePeer::ID);
        $c->setDistinct();

        $templates = $this->getJobMessageTemplates($c);
        var_dump($templates);die;
        return $single_row ? (count($templates) ? $templates[0] : null) : $templates;
    }
    
    public function getAvailableTemplateTypesFor($type_id = null)
    {
        $types = array();
        
        $con = Propel::getConnection();
        $sql = "SELECT TYPE_ID FROM EMT_JOB_MESSAGE_TEMPLATE WHERE HR_PROFILE_ID={$this->getId()}";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $existing = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        foreach (UserJobPeer::$statusLabels as $key => $label)
        {
            if (!in_array($key, $existing) || ($type_id != null && $key == $type_id))
            {
                $types[$key] = $label;
            }
        }
        return $types;
    }
    
    public function searchVault($keyword, $channels = array(), $return_type = null, $folder_id = null)
    {
        $channels = array_filter($channels);
        if (!is_array($channels)) $channels = array();
        
        $chnls = array('OR');
        
        if (in_array(DatabaseCVPeer::CHANNEL_APPLICATION, $channels) || !count($channels))
            $chnls[] = array('AND',
                        array(ResumePeer::RSM_CRT_APPLIED_JOB_OWNER_ID, ResumePeer::RSM_OPR_EQUAL, $this->getOwnerId()),
                        array(ResumePeer::RSM_CRT_APPLIED_JOB_OWNER_TYPE_ID, ResumePeer::RSM_OPR_EQUAL, $this->getOwnerTypeId()),
                        array(ResumePeer::RSM_CRT_USER_JOB_TYPE_ID, ResumePeer::RSM_OPR_EQUAL, UserJobPeer::UJTYP_APPLIED),
                       );
       
        if (in_array(DatabaseCVPeer::CHANNEL_SERVICE, $channels) || !count($channels))
            $chnls[] = array(ResumePeer::RSM_CRT_DATABASE_PROFILE_ID, ResumePeer::RSM_OPR_EQUAL, $this->getId());

        if (in_array(DatabaseCVPeer::CHANNEL_REFERRAL, $channels) || !count($channels))
        {
            // fill when service is ready
            $chnls[] = array(1, ResumePeer::RSM_OPR_EQUAL, 2);
        }

        $keyword_criteria = !$keyword ? null : array('OR', 
            array(ResumePeer::RSM_CRT_USER_NAME_LASTNAME, ResumePeer::RSM_OPR_LIKE, $keyword), 
            array(ResumePeer::RSM_CRT_EDU_SCHOOL_NAME, ResumePeer::RSM_OPR_LIKE, $keyword),
            array(ResumePeer::RSM_CRT_EDU_MAJOR, ResumePeer::RSM_OPR_LIKE, $keyword),
            array(ResumePeer::RSM_CRT_WORK_COMPANY_NAME, ResumePeer::RSM_OPR_LIKE, $keyword),
            array(ResumePeer::RSM_CRT_WORK_POSITION, ResumePeer::RSM_OPR_LIKE, $keyword) 
        );

        $folder_criteria = !$folder_id ? null : array(ResumePeer::RSM_CRT_FOLDER_ID, ResumePeer::RSM_OPR_EQUAL, $folder_id); 

        return ResumePeer::searchByCriteria(array_values(array_filter(array('AND', $keyword_criteria, $folder_criteria, $chnls))), $return_type);
    }
    
    public function searchCVDB($keyword, $return_type = null)
    {
        $used_items = PurchasePeer::getUsedItemsFor($this->getOwnerId(), $this->getOwnerTypeId(), ServicePeer::STYP_ACCESS_CV_DB, true);
        $purchased_items = PurchasePeer::getPurchasedItemCountFor($this->getOwnerId(), $this->getOwnerTypeId(), ServicePeer::STYP_ACCESS_CV_DB, true);
        if (!(myTools::fixInt($purchased_items) - myTools::fixInt($used_items) > 0)) return null;
        
        $keyword_criteria = !$keyword ? null : array('OR', 
            array(ResumePeer::RSM_CRT_USER_NAME_LASTNAME, ResumePeer::RSM_OPR_LIKE, $keyword), 
            array(ResumePeer::RSM_CRT_EDU_SCHOOL_NAME, ResumePeer::RSM_OPR_LIKE, $keyword),
            array(ResumePeer::RSM_CRT_EDU_MAJOR, ResumePeer::RSM_OPR_LIKE, $keyword),
            array(ResumePeer::RSM_CRT_WORK_COMPANY_NAME, ResumePeer::RSM_OPR_LIKE, $keyword),
            array(ResumePeer::RSM_CRT_WORK_POSITION, ResumePeer::RSM_OPR_LIKE, $keyword) 
        );

        return ResumePeer::searchDB(array_values(array_filter(array('AND', $keyword_criteria, $folder_criteria, $chnls))), $this->getId(), $return_type);
    }
    
    public function getCVPager($page, $items_per_page = 20, $c1 = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }

        $pager = new sfPropelPager('Resume', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);

        $pager->init();
        return $pager;
    }
    
    public function findVaultCV($resume_id)
    {
        $chnls = array('OR');
        
        $chnls[] = array('AND',
                    array(ResumePeer::RSM_CRT_APPLIED_JOB_OWNER_ID, ResumePeer::RSM_OPR_EQUAL, $this->getOwnerId()),
                    array(ResumePeer::RSM_CRT_APPLIED_JOB_OWNER_TYPE_ID, ResumePeer::RSM_OPR_EQUAL, $this->getOwnerTypeId()),
                    array(ResumePeer::RSM_CRT_USER_JOB_TYPE_ID, ResumePeer::RSM_OPR_EQUAL, UserJobPeer::UJTYP_APPLIED),
                   );
   
        $chnls[] = array(ResumePeer::RSM_CRT_DATABASE_PROFILE_ID, ResumePeer::RSM_OPR_EQUAL, $this->getId());

        $chnls[] = array(1, ResumePeer::RSM_OPR_EQUAL, 2);

        // add criteria for database browse service when service is ready

        $id_criteria = array(ResumePeer::RSM_CRT_RESUME_ID, ResumePeer::RSM_OPR_EQUAL, $resume_id);

        $cvs = ResumePeer::searchByCriteria(array_values(array_filter(array('AND', $id_criteria, $chnls))));
        return count($cvs) ? $cvs[0] : null; 
    }
    
    
    
}
