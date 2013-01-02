<?php

class jobsAction extends EmtCVAction
{
    public function execute($request)
    {
        $this->group = myTools::pick_from_list($this->getRequestParameter('group'), array('applied', 'bookmarked', 'viewed'), 'applied');
        $this->page = myTools::fixInt($this->getRequestParameter('page'));
        
        if ($this->group == 'applied' && ($jobid = $this->getRequestParameter('guid')) &&  ($this->ujob = $this->sesuser->getUserJob($jobid, UserJobPeer::UJTYP_APPLIED)))
        {
            $this->job = $this->ujob->getJob();

            if ($this->getRequestParameter('act') == 'term')
            {
                if ($this->getRequestParameter('do')=='commit' && $this->getRequestParameter('has') == $this->getUser()->getAttribute('termjob', null, '/hr/myjobs/terminate'))
                {
                    $this->ujob->setStatusId(UserJobPeer::UJ_STATUS_TERMINATED);
                    $this->ujob->save();

                    if ($this->getRequest()->isXmlHttpRequest())
                        return $this->renderPartial('global/ajaxSuccess', array(
                                        'message' => $this->getContext()->getI18N()->__('Your job application has been terminated.'),
                                        'redir' => "@myjobs-applied"
                                    ));
                    else
                        $this->redirect("@myjobs-applied");
                }
                else
                {
                    $this->getUser()->setAttribute('termjob', $this->confirmterm = base64_encode(date('U')), '/hr/myjobs/terminate');
                    if ($this->getRequest()->isXmlHttpRequest())
                        return $this->renderPartial('confirmJobAppTerminate', array('sf_params' => $this->getRequest()->getParameterHolder(), 'job' => $this->job, 'confirmterm' => $this->confirmterm, 'sf_request' => $this->getRequest()));
                }

            }
            $this->messages = $this->ujob->getMessagings();
            $this->setTemplate('jobStatus');
            return sfView::SUCCESS;
        }

        $c = new Criteria();
        if ($this->group == 'applied' || $this->group == 'bookmarked')
        {
            $c->add(UserJobPeer::USER_ID, $this->sesuser->getId());
            $c->add(UserJobPeer::TYPE_ID, $this->group == 'applied' ? UserJobPeer::UJTYP_APPLIED : UserJobPeer::UJTYP_FAVOURITE);
            $c->addDescendingOrderByColumn(UserJobPeer::CREATED_AT);
        }
        else if ($this->group == 'viewed')
        {
            $sql = "
                SELECT EMT_JOB.*, RATER.CREATED_AT VIEW_DATE 
                FROM 
                (
                    SELECT EMT_RATING.*, 
                    RANK() OVER (PARTITION BY ITEM_ID ORDER BY CREATED_AT) SEQNUMBER
                    FROM EMT_RATING
                    WHERE ITEM_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_JOB." AND VISITOR_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND VISITOR_ID={$this->sesuser->getId()}
                ) RATER
                LEFT JOIN EMT_JOB ON RATER.ITEM_ID=EMT_JOB.ID
                WHERE SEQNUMBER=1 AND EXISTS (SELECT 1 FROM EMT_JOB_VIEW WHERE ID=EMT_JOB.ID)
                ORDER BY VIEW_DATE DESC
            ";            
            $this->pager = new EmtPager('Job', 10);
            $this->pager->setPage($this->page);
            $this->pager->setSql($sql);
            $this->pager->setBindColumns(array('viewdate' => JobPeer::NUM_COLUMNS));
            $this->pager->init();
            return sfView::SUCCESS;
        }
        
        $this->pager = new sfPropelPager('UserJob', 10);
        $this->pager->setCriteria($c);
        $this->pager->setPage($this->page);
        $this->pager->init();
    }
    
    public function handleError()
    {
    }
    
}


