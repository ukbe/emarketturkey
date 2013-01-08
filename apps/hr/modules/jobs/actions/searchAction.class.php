<?php

class searchAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['action']);
        unset($params['sf_culture']);
        $this->redirect("@camp.jobsearch?".http_build_query($params), 301);

        $this->timer = new sfTimer();
        $this->timer->startTimer();
        
        $this->page = myTools::fixInt($this->getRequestParameter('page'));
        
        $this->commit = ($this->getRequestParameter('do') == 'search');
        
        $params = $sqls = array();
        
        $params['keyword'] = $this->getRequestParameter('job_keyword', null);
        $params['period'] = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('period')), array(1, 3, 7, 15, 30, 60, 360), 360);
        $params['country'] = CountryPeer::validateIdList($this->getRequestParameter('cnt'));
        $params['grade'] = JobGradePeer::validateIdList(myTools::fixInt($this->getRequestParameter('grd')));
        $params['edulevel'] = ResumeSchoolDegreePeer::validateIdList(myTools::fixInt($this->getRequestParameter('edu')));
        $params['scheme'] = JobWorkingSchemePeer::validateIdList(myTools::fixInt($this->getRequestParameter('sch')));
        $params['mservice'] = ResumePeer::validateMilServIdList(myTools::fixInt($this->getRequestParameter('mserv')));
        $params['gender'] = ResumePeer::validateGenderOptIdList(myTools::fixInt($this->getRequestParameter('gen')));
        $params['scase'] = JobSpecialCasesPeer::validateIdList(myTools::fixInt($this->getRequestParameter('scs')));

        $params = array_filter($params);

        $this->filter = new EmtJobFilter($params);

        if ($this->commit)
        {
            if (isset($params['period']))
                $sqls['period'] = "EXISTS (SELECT 1 FROM EMT_JOB_SPEC WHERE JOB_ID=EMT_JOB.ID AND TYPE_ID=".JobSpecPeer::JSPTYP_PUBLISHED_ON." AND TRUNC(unixts_to_date(SPEC_ID)) >= TRUNC(SYSDATE)-{$params['period']})";
            
            if (isset($params['country']))
                $sqls['country'] = "EXISTS (SELECT 1 FROM EMT_JOB_LOCATION WHERE JOB_ID=EMT_JOB.ID AND COUNTRY_CODE IN ('".implode("', '", $params['country'])."'))";
    
            if (isset($params['keyword']) && ($keyword = $params['keyword']))
                $sqls['keyword'] = "(".myTools::NLSFunc(JobPeer::TITLE, 'UPPER')." LIKE UPPER('%$keyword%')) 
                                 OR (EXISTS (
                                        SELECT 1 FROM EMT_JOB_I18N
                                        WHERE EMT_JOB_I18N.ID=EMT_JOB.ID
                                           AND (
                                            (".myTools::NLSFunc(JobI18nPeer::DISPLAY_TITLE, 'UPPER')." LIKE UPPER('%$keyword%'))
                                            OR (".myTools::NLSFunc(JobI18nPeer::DESCRIPTION, 'UPPER')." LIKE UPPER('%$keyword%'))
                                            OR (".myTools::NLSFunc(JobI18nPeer::REQUIREMENTS, 'UPPER')." LIKE UPPER('%$keyword%'))
                                            OR (".myTools::NLSFunc(JobI18nPeer::RESPONSIBILITY, 'UPPER')." LIKE UPPER('%$keyword%'))
                                           )
                                       ))
                                 ";
    
            if (isset($params['grade']))
                $sqls['grade'] = "EXISTS (SELECT 1 FROM EMT_JOB_SPEC WHERE JOB_ID=EMT_JOB.ID AND TYPE_ID=".JobSpecPeer::JSPTYP_JOB_GRADE." AND SPEC_ID IN (".implode(',', $params['grade'])."))";
            
            if (isset($params['edulevel']))
                $sqls['edulevel'] = "EXISTS (SELECT 1 FROM EMT_JOB_SPEC WHERE JOB_ID=EMT_JOB.ID AND TYPE_ID=".JobSpecPeer::JSPTYP_SCHOOL_DEGREE." AND SPEC_ID IN (".implode(',', $params['edulevel'])."))";
            
            if (isset($params['scheme']))
                $sqls['scheme'] = "EXISTS (SELECT 1 FROM EMT_JOB_SPEC WHERE JOB_ID=EMT_JOB.ID AND TYPE_ID=".JobSpecPeer::JSPTYP_WORKING_SCHEME." AND SPEC_ID IN (".implode(',', $params['scheme'])."))";
            
            if (isset($params['mservice']))
                $sqls['mservice'] = "EXISTS (SELECT 1 FROM EMT_JOB_SPEC WHERE JOB_ID=EMT_JOB.ID AND TYPE_ID=".JobSpecPeer::JSPTYP_MILSERV_STATUS." AND SPEC_ID IN (".implode(',', $params['mservice'])."))";
            
            if (isset($params['gender']))
                $sqls['gender'] = "EXISTS (SELECT 1 FROM EMT_JOB_SPEC WHERE JOB_ID=EMT_JOB.ID AND TYPE_ID=".JobSpecPeer::JSPTYP_GENDER." AND SPEC_ID IN (".implode(',', $params['gender'])."))";
            
            if (isset($params['scase']))
                $sqls['scase'] = "EXISTS (SELECT 1 FROM EMT_JOB_SPEC WHERE JOB_ID=EMT_JOB.ID AND TYPE_ID=".JobSpecPeer::JSPTYP_SPECIAL_CASE." AND SPEC_ID IN (".implode(',', $params['scase'])."))";
            
            $sql = "SELECT * FROM EMT_JOB_VIEW EMT_JOB WHERE (".implode(') AND (', $sqls).") AND STATUS=".JobPeer::JSTYP_ONLINE."";
    
            $this->pager  = new EmtPager('Job', 20);
            $this->pager->setSql($sql);
            $this->pager->setPage($this->page);
            $this->pager->init();
        }
        $this->params = $params;
    }
    
    public function handleError()
    {
    }
    
}