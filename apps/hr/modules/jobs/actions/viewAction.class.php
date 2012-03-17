<?php

class viewAction extends EmtJobAction
{
    public function execute($request)
    {
        $act = myTools::pick_from_list($this->getRequestParameter('act'), array('apply', 'save', 'rem', 'cancel'), null);
        if ($act)
        {
            if ($this->sesuser->isNew())
            {
                $this->redirect('@myemt.login?_ref='.$this->_here);
            }

            $fav = $this->sesuser->getUserJob($this->job->getId(), UserJobPeer::UJTYP_FAVOURITE);
            $app = $this->sesuser->getUserJob($this->job->getId(), UserJobPeer::UJTYP_APPLIED);
            if ($act == 'rem' && $fav)
            {
                $fav->delete();
                $this->getUser()->setAttribute('act', array('rem', $this->job->getHash()), '/hr/jobs');
            }
            if ($act == 'cancel' && $app)
            {
                $app->delete();
                $this->getUser()->setAttribute('act', array('ban', $this->job->getHash()), '/hr/jobs');
            }
            if (($act == 'save' && !$fav) || ($act == 'apply' && $this->sesuser->canApplyToJob($this->job)))
            {
                if ($app)
                {
                    $app->setStatusId(UserJobPeer::UJ_STATUS_PENDING);
                    $app->save();
                    $userjob = $app;
                }
                else
                {
                    $userjob = new UserJob();
                    $userjob->setUserId($this->sesuser->getId());
                    $userjob->setJobId($this->job->getId());
                    $userjob->setTypeId($act == 'save' ? UserJobPeer::UJTYP_FAVOURITE : UserJobPeer::UJTYP_APPLIED);
                    $userjob->save();
                }
                $this->getUser()->setAttribute('act', array($act, $this->job->getHash()), '/hr/jobs');
            }
            $this->redirect($this->job->getUrl());
        }

        $act = $this->getUser()->getAttribute('act', null, '/hr/jobs');
        if ($act && is_array($act) && count($act) == 2 && $act[1] == $this->job->getHash())
        {
            $act = $act[0];
            $this->getUser()->getAttributeHolder()->remove('act', null, '/hr/jobs');
            $this->messages = array('save'   => 'Job has been successfully added to bookmarks.',
                                    'rem'    => 'Job has been successfully removed from bookmarks.',
                                    'apply'  => 'Your application has been successfully received.',
                                    'cancel' => 'Your application has been successfully cancelled.',
                                );
        }
        else 
        {
            $act = null;
            $this->getUser()->getAttributeHolder()->remove('act', null, '/hr/jobs');
        }
        $this->act = $act;
        
        if ($this->getRequest()->isXmlHttpRequest())
            return $this->renderPartial('jobs/ajax_job', array('job' => $this->job, 'owner' => $this->owner));

        $this->empjobs = $this->owner->getOnlineJobs();

        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("Job Details: %1", array('%1' => $this->job->getDisplayTitle() ? $this->job->getDisplayTitle() : $this->job->getTitle())) . ' | ' . $this->owner . ' | eMarketTurkey');

        $topowner = PrivacyNodeTypePeer::getTopOwnerOf($this->owner);

        if ($topowner && $topowner->getId() == $this->sesuser->getId())
            $this->user_owns_job = true;
        else
            $this->user_owns_job = false;

        $this->hrprofile = $this->owner->getHRProfile();
        
        if (!$this->user_owns_job) RatingPeer::logNewVisit($this->job->getId(), PrivacyNodeTypePeer::PR_NTYP_JOB);

    }
    
    public function handleError()
    {
    }
    
}