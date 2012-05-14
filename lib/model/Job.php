<?php

class Job extends BaseJob
{
    private $hash = null;
        
    public function __toString()
    {
        return $this->getDisplayTitle() ? $this->getDisplayTitle() : $this->getDefaultTitle();
    }

    public function getDefaultTitle()
    {
        return $this->getDisplayTitle($this->getDefaultLang());
    }
    
    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_JOB;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_JOB) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getUrl()
    {
        if (sfContext::getInstance()->getConfiguration()->getApplication() == "hr")
        return "@job?guid=" . $this->getGuid();
        else
        return "@hr.job?guid=" . $this->getGuid();
    }

    public function getManageUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . ($this->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "company-job-action?action=details&hash={$this->getOwner()->getHash()}&guid={$this->getGuid()}" : "group-job-action?action=details&hash={$this->getOwner()->getHash()}&guid={$this->getGuid()}");  
    }

    public function getApplicantsUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . ($this->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "company-job-action?action=applicants&hash={$this->getOwner()->getHash()}&guid={$this->getGuid()}" : "group-job-action?action=applicants&hash={$this->getOwner()->getHash()}&guid={$this->getGuid()}");  
    }

    public function getApplicantUrl($user_job_id)
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . ($this->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "company-job-action?action=previewCV&hash={$this->getOwner()->getHash()}&guid={$this->getGuid()}&appid=$user_job_id" : "group-job-action?action=previewCV&hash={$this->getOwner()->getHash()}&guid={$this->getGuid()}&appid=$user_job_id");  
    }

    public function getEditUrl()
    {
       return (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . ($this->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "company-job-action?action=post&hash={$this->getOwner()->getHash()}&guid={$this->getGuid()}" : "group-job-action?action=post&hash={$this->getOwner()->getHash()}&guid={$this->getGuid()}");  
    }

    public function getLogo()
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::ITEM_TYPE_ID, MediaItemPeer::MI_TYP_JOB_POST_IMAGE);
        $logo_ar = $this->getMediaItems($c);
        if (is_array($logo_ar) && count($logo_ar))
            return $logo_ar[0];
        else
            return null;
    }
    
    public function getLogoUri($size = MediaItemPeer::LOGO_TYP_SMALL)
    {
        $logo = $this->getLogo();
        if ($logo)
        {
            switch ($size)
            {
                case MediaItemPeer::LOGO_TYPE_MEDIUM :
                    return $logo->getMediumUri();
                    break;
                case MediaItemPeer::LOGO_TYPE_LARGE :
                    return $logo->getUri();
                    break;
                case MediaItemPeer::LOGO_TYP_SMALL :
                default: 
                    return $logo->getThumbnailUri();
                    break;
            }
        }
        else
        {
            switch ($size)
            {
                case MediaItemPeer::LOGO_TYPE_MEDIUM :
                    return "layout/background/nologo.medium.png";
                    break;
                case MediaItemPeer::LOGO_TYPE_LARGE :
                    return "layout/background/nologo.png";
                    break;
                case MediaItemPeer::LOGO_TYP_SMALL :
                default: 
                    return "layout/background/nologo.thumb.png";
                    break;
            }
        }
    }

    public function getMediaItems($c1 = null)
    {
        if (is_int($c1))
        {
            return MediaItemPeer::retrieveItemsFor($this->getId() ? $this->getId() : 0, PrivacyNodeTypePeer::PR_NTYP_JOB, $c1);
        }
        
        if ($c1)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_JOB);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        
        return MediaItemPeer::doSelect($c);
    }
    
    public function getSpotBoxBackground()
    {
        return $img = $this->getImage(MediaItemPeer::MI_TYP_JOB_SPOTBOX_BACK) ? $img : $this->getOwner()->getHRProfile()->getSpotBoxBackground();
    }

    public function getPlatinumImage()
    {
        return $img = $this->getImage(MediaItemPeer::MI_TYP_JOB_PLATINUM_IMAGE) ? $img : $this->getOwner()->getHRProfile()->getPlatinumImage();
    }

    public function getRectBoxImage()
    {
        return $img = $this->getImage(MediaItemPeer::MI_TYP_JOB_RECTBOX_IMAGE) ? $img : $this->getOwner()->getHRProfile()->getRectBoxImage();
    }

    public function getCubeBoxImage()
    {
        return $img = $this->getImage(MediaItemPeer::MI_TYP_JOB_CUBEBOX_IMAGE) ? $img : $this->getOwner()->getHRProfile()->getCubeBoxImage();
    }

    public function getImage($type_id)
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::ITEM_TYPE_ID, $type_id);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        $c->add(MediaItemPeer::OWNER_TYPE_ID, $this->getObjectTypeId());
        return MediaItemPeer::doSelectOne($c);
    }
    
    public function getOwner()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getOwnerId(), $this->getOwnerTypeId());
    }
    
    public function getCountry()
    {
        return $this->getGeonameCity()?$this->getGeonameCity()->getParent():null;
    }

    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentJobI18n($culture);
        return $lsi->isNew()?false:true;
    }
    
    public function getExistingI18ns()
    {
        if ($this->isNew())
        {
            return array();
        }
        else
        {
            $con = Propel::getConnection();
            
            $sql = "SELECT CULTURE FROM EMT_JOB_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(JobI18nPeer::ID, $this->getId());
        $c->add(JobI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return JobI18nPeer::doDelete($c);
    }
    
    public function countApplicants()
    {
        $c = new Criteria();
        $c->add(UserJobPeer::TYPE_ID, UserJobPeer::UJTYP_APPLIED);
        return $this->countUserJobs($c);
    }

    public function getApplicantPager($page, $items_per_page = 20, $c1 = null, $status = null, $flag = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }

        switch ($flag)
        {
            case UserJobPeer::UJ_STAT_TYP_ALL :
                $c->add(UserJobPeer::FLAG_TYPE, UserJobPeer::UJ_EMPLYR_FLAG_IGNORE, Criteria::NOT_EQUAL); 
                break;
            case UserJobPeer::UJ_STAT_TYP_READ :
                $c->add(UserJobPeer::EMPLOYER_READ, "1"); 
                $c->add(UserJobPeer::FLAG_TYPE, UserJobPeer::UJ_EMPLYR_FLAG_IGNORE, Criteria::NOT_EQUAL); 
                break;
            case UserJobPeer::UJ_STAT_TYP_UNREAD : 
                $c->add(UserJobPeer::EMPLOYER_READ, "0"); 
                $c->add(UserJobPeer::FLAG_TYPE, UserJobPeer::UJ_EMPLYR_FLAG_IGNORE, Criteria::NOT_EQUAL); 
                break;
            case UserJobPeer::UJ_STAT_TYP_FAVOURITE : 
                $c->add(UserJobPeer::FLAG_TYPE, UserJobPeer::UJ_EMPLYR_FLAG_FAVOURITE); 
                break;
            case UserJobPeer::UJ_STAT_TYP_IGNORED : 
                $c->add(UserJobPeer::FLAG_TYPE, UserJobPeer::UJ_EMPLYR_FLAG_IGNORE); 
                break;
        }
        if (!is_null($status)) $c->add(UserJobPeer::STATUS_ID, $status);
        $c->add(UserJobPeer::JOB_ID, $this->getId());
        $c->add(UserJobPeer::TYPE_ID, UserJobPeer::UJTYP_APPLIED);
        $c->addAscendingOrderByColumn(UserJobPeer::CREATED_AT);
        $pager = new sfPropelPager('UserJob', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }
    
    public function getPrevNextOfApp($app_id, $status, $keyword = null, $orderby = 'CREATED_AT ASC',  $flag = null)
    {
        switch ($flag)
        {
            case UserJobPeer::UJ_STAT_TYP_ALL :
                $flag_criteria = " AND FLAG_TYPE<>".UserJobPeer::UJ_EMPLYR_FLAG_IGNORE; 
                break;
            case UserJobPeer::UJ_STAT_TYP_READ :
                $flag_criteria = " AND EMPLOYER_READ=1 AND FLAG_TYPE<>".UserJobPeer::UJ_EMPLYR_FLAG_IGNORE; 
                break;
            case UserJobPeer::UJ_STAT_TYP_UNREAD : 
                $flag_criteria = " AND EMPLOYER_READ=0 AND FLAG_TYPE<>".UserJobPeer::UJ_EMPLYR_FLAG_IGNORE; 
                break;
            case UserJobPeer::UJ_STAT_TYP_FAVOURITE : 
                $flag_criteria = " AND FLAG_TYPE=".UserJobPeer::UJ_EMPLYR_FLAG_FAVOURITE; 
                break;
            case UserJobPeer::UJ_STAT_TYP_IGNORED : 
                $flag_criteria = " AND FLAG_TYPE=".UserJobPeer::UJ_EMPLYR_FLAG_IGNORE; 
                break;
            default: $flag_criteria = "";
        }
        
        $con = Propel::getConnection();
        
        $sql = "SELECT * FROM 
        (
            SELECT ID,
            LAG(ID, 1, NULL) OVER (ORDER BY $orderby) AS PREV_ID,
            LEAD(ID, 1, NULL) OVER (ORDER BY $orderby) AS NEXT_ID 
            FROM EMT_USER_JOB 
            WHERE JOB_ID={$this->getId()} AND TYPE_ID=".UserJobPeer::UJTYP_APPLIED."
                  AND STATUS_ID=$status $flag_criteria
            ORDER BY CREATED_AT
        )
        WHERE ID=$app_id
        ";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getApplicants()
    {
        $c = new Criteria();
        $c->add(UserJobPeer::TYPE_ID, UserJobPeer::UJTYP_APPLIED);
        $c->addDescendingOrderByColumn(UserJobPeer::CREATED_AT);
        return $this->getUserJobs($c);
    }
    
    public function getApplicant($app_id)
    {
        $c = new Criteria();
        $c->add(UserJobPeer::ID, $app_id);
        $c->add(UserJobPeer::TYPE_ID, UserJobPeer::UJTYP_APPLIED);
        $app = $this->getUserJobs($c);
        return count($app) ? $app[0] : null;
    }
    
    public function getNewApplicants($count = false)
    {
        $con = Propel::getConnection();

        $sql = "
            SELECT ".($count ? "COUNT(*)" : "EMT_USER.*")." FROM EMT_USER_JOB
            LEFT JOIN EMT_JOB ON EMT_USER_JOB.JOB_ID=EMT_JOB.ID
            LEFT JOIN EMT_USER ON EMT_USER_JOB.USER_ID=EMT_USER.ID
            WHERE EMT_JOB.ID=".($this->getId()?$this->getId():0)." AND EMT_USER_JOB.TYPE_ID=".UserJobPeer::UJTYP_APPLIED."
                AND NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE EMT_BLOCKLIST.LOGIN_ID=EMT_USER.LOGIN_ID AND EMT_BLOCKLIST.ACTIVE=1)
                AND EMT_USER_JOB.CREATED_AT > unixts_to_date('{$this->getOwner()->getOwnerLastLoginDate('U')}')
            ORDER BY EMT_USER_JOB.CREATED_AT DESC
        ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        return $count ? $stmt->fetch(PDO::FETCH_COLUMN, 0) : UserPeer::populateObjects($stmt);
    }
    
    public function getApplicantCountByStatus()
    {
        $con = Propel::getConnection();
        
        $sql = "SELECT STATUS_ID, COUNT(*) CNT FROM EMT_USER_JOB
                WHERE JOB_ID={$this->getId()} AND TYPE_ID=".UserJobPeer::UJTYP_APPLIED."
                GROUP BY STATUS_ID
                ORDER BY STATUS_ID";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $arr = array();
        foreach ($rows as $row)
        {
            $arr[$row['STATUS_ID']] = $row['CNT'];
        }
        
        return $arr;
    }
    
    public function getClob($field, $culture = null)
    {
        $conf = Propel::getConfiguration();
        $conf = $conf['datasources'][$conf['datasources']['default']]['connection'];
        
        if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
        if (!($c = @oci_connect($conf['user'], $conf['password'], $conf['database'])))
        {echo "no connection";}
        
        $sql = "SELECT $field 
                FROM EMT_JOB_I18N 
                WHERE ID={$this->getId()} AND CULTURE='$culture'";
        $stmt = oci_parse($c, $sql);
        oci_execute($stmt);
        $res = oci_fetch_row($stmt);
        return isset($res[0]) ? $res[0]->load() : "";
    }
    
    public function getDefineText($to_user = null, $target_culture = null)
    {
        if (!$to_user) $to_user = sfContext::getInstance()->getUser()->getUser();
        $top_owner = PrivacyNodeTypePeer::getTopOwnerOf($this);
        $is_owner = ($top_owner && $to_user->getId() == $top_owner->getId()) ? true : false;
        $owner = $this->getOwner();

        $i18n = sfContext::getInstance()->getI18N();
        $cl = $i18n->getCulture();
        if ($target_culture)
        {
            $culture = $target_culture;
            $i18n->setCulture($culture);
        }
        else
        {
            $culture = $cl;
        }
    
        $result = $i18n->__("a job post");
        
        $result = $is_owner ? $i18n->__("your company %1c's job post %2j", array('%1c' => $owner, '%2j' => $this)) : $i18n->__("a job posting of %1c", array('%1c' => $owner));
        
        if ($target_culture) $i18n->setCulture($cl);
        return $result;
    }
    
    public function getLocationString($format = ':')
    {
        $locs = $this->getLocations();
        
        $arr = array();
        
        foreach ($locs as $loc) $arr[] = $loc->formatText($format);
        
        return implode(' | ', $arr);
    }
    
    public function getLocations($country_code = null, $geo_id = null, $single_row = false)
    {
        $c = new Criteria();
        if (isset($country_code) && $country_code != '') $c->add(JobLocationPeer::COUNTRY_CODE, $country_code);
        if (isset($geo_id) && is_numeric($geo_id)) $c->add(JobLocationPeer::LOCATION_ID, $geo_id);
        $ls = $this->getJobLocations($c);
        return $single_row && count($ls) ? $ls[0] : $ls;
    }
    
    public function getSpec($type_id, $spec_value_id = null)
    {
        $c = new Criteria();
        $c->add(JobSpecPeer::TYPE_ID, $type_id);
        if ($spec_value_id) $c->add(JobSpecPeer::SPEC_ID, $spec_value_id);
        $c->addAscendingOrderByColumn(JobSpecPeer::ID);
        $js = $this->getJobSpecs($c);
        $js = count($js) ? (JobSpecPeer::$typeLimits[$type_id] == 0 || JobSpecPeer::$typeLimits[$type_id] > 1 ? $js : $js[0]) : (JobSpecPeer::$typeLimits[$type_id] == 0 || JobSpecPeer::$typeLimits[$type_id] > 1 ? array() : null); 
        return $spec_value_id==null ? $js : (count($js) ? $js[0] : null);
    }

    public function addSpec($type_id, $spec_value_id, $allow_overwrite = false)
    {
        $specs = $this->getSpec($type_id);
        $spec = $this->getSpec($type_id, $spec_value_id);
        
        if (array_key_exists($type_id, JobSpecPeer::$typeNames) && !$spec && (JobSpecPeer::$typeLimits[$type_id] == 0 || $allow_overwrite || count($specs) < JobSpecPeer::$typeLimits[$type_id]))
        {
            if ($allow_overwrite && (JobSpecPeer::$typeLimits[$type_id] > 0 && count($specs) >= JobSpecPeer::$typeLimits[$type_id]))
            {
                $i = 0;
                while (count($specs) >= JobSpecPeer::$typeLimits[$type_id]){
                    $i++;
                    $specs[0]->delete();
                    array_shift($specs);
                }
            }

            $spec = new JobSpec();
            $spec->setJobId($this->getId());
            $spec->setTypeId($type_id);
            $spec->setSpecId($spec_value_id);
            $spec->save();
            return $spec;
        }
        return false;
    }

    public function removeSpec($type_id, $spec_value_id = null)
    {
        if (array_key_exists($type_id, JobSpecPeer::$typeNames) && ($spec = $this->getSpec($type_id, $spec_value_id)))
        {
            $spec->delete();
            return true;
        }
        return false;
    }
    
    public function getPublishedOn($format = 'U')
    {
        $online_since = $this->getSpec(JobSpecPeer::JSPTYP_PUBLISHED_ON);
        return $online_since ? date($format, $online_since->getSpecId()) : null;
    }
    
    public function getDeadline($format = 'U')
    {
        $online_since = $this->getSpec(JobSpecPeer::JSPTYP_PUBLISHED_ON);
        $online_since = $online_since ? $online_since->getSpecId() : null;
        $period = $this->getSpec(JobSpecPeer::JSPTYP_ONLINE_DAYS_LIMIT);
        $period = $period ? $period->getSpecId() : 60;
        
        return $this->getStatus() == JobPeer::JSTYP_ONLINE && $online_since && $period ? date($format, mktime(0, 0, 0, date('m', $online_since), date('d', $online_since) + $period, date('Y', $online_since))) : null;
    }
    
    public function getDaysLeftToDeadline()
    {
        $deadline = $this->getDeadline('U');
        $days = floor(($deadline - date('U')) / (60*60*24));
        
        return $days > 0 ? $days : 0;
    }
    
    public function  getObjectOrValueOfSpecType($type_id)
    {
        $spec = $this->getSpec($type_id);
        $result = array();
        if (is_array($spec))
        {
            foreach ($spec as $sp)
            {
                $result[] = $sp->getRelatedObjectOrValue();
            }
        }
        else if ($spec)
        {
            $result = $spec->getRelatedObjectOrValue();
        }
        return $result ? $result : null;
    }
    
    public function setStatus($status_id)
    {
        $statSwap = array(JobPeer::JSTYP_ONLINE => array(JobPeer::JSTYP_OFFLINE, JobPeer::JSTYP_SUSPENDED),
                          JobPeer::JSTYP_SUSPENDED => array(JobPeer::JSTYP_ONLINE, JobPeer::JSTYP_OFFLINE),
                          JobPeer::JSTYP_OBSOLETE => array(),
                          JobPeer::JSTYP_OFFLINE => array(JobPeer::JSTYP_ONLINE)
                    );

        if (in_array($status_id, $statSwap[$this->getStatus()]))
        {
            switch ($status_id)
            {
                case JobPeer::JSTYP_ONLINE :
                    
                    break;
                case JobPeer::JSTYP_SUSPENDED :
                    break;
                case JobPeer::JSTYP_OFFLINE :
                    break;
                case JobPeer::JSTYP_OBSOLETE :
                    break;
            }
            $this->setStatus($status_id);
        }
    }
    
    public function getTopSpecsText($return_array = false, $num = 1)
    {
        $array = array_filter(
                    array($this->getLocationString(),
                       $this->getSpec(JobSpecPeer::JSPTYP_JOB_GRADE),
                    )
                );
        if ($num) array_splice($array, 0, $num);
        return !$return_array && count($array) ? $array[0] : ($return_array ? $array : null);
    }
}
