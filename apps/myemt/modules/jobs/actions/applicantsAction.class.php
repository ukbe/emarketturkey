<?php

class applicantsAction extends EmtManageJobAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Job Applicants: %1', array('%1' => $this->job->getTitle())));
        
        $this->ipps = array('extended'  => array(10, 20, 50),
                            'list'      => array(10, 20, 50, 100),
                            'thumbs'    => array(20, 50, 100, 150)
                        );
        
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->status = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('status')), array_keys(UserJobPeer::$statusLabels), UserJobPeer::UJ_STATUS_PENDING);
        $this->view = myTools::pick_from_list($this->getRequestParameter('view'), array_keys($this->ipps), 'list');
        $this->ipp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ipp')), $this->ipps[$this->view], 20);

        $this->getUser()->setAttribute('keyword', $this->keyword, '/myemt/jobs/applicants/browse');
        $this->getUser()->setAttribute('status', $this->status, '/myemt/jobs/applicants/browse');

        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(UserJobPeer::USER_ID, UserPeer::ID);
            $c->add(UserPeer::NAME, "UPPER(".UserPeer::NAME." || ".UserPeer::LASTNAME.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
        }
        
        $this->pager = $this->job->getApplicantPager($this->page, $this->ipp, $c, $this->status);
        
        $this->appcount = $this->job->getApplicantCountByStatus();
    }
    
    public function handleError()
    {
    }
    
}
