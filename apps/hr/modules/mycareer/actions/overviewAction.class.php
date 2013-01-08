<?php

class overviewAction extends EmtCVAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['action']);
        unset($params['sf_culture']);
        $this->redirect("@camp.mycareer?".http_build_query($params), 301);

        if ($this->resume)
            $this->missingitems = $this->resume->getMissingInfoList();
        else
            $this->missingitems = array();

        $c = new Criteria();
        $c->addJoin(RatingPeer::ITEM_ID, JobPeer::ID, Criteria::LEFT_JOIN);
        $c->add(RatingPeer::ITEM_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_JOB);
        $c->add(RatingPeer::VISITOR_ID, $this->sesuser->getId());
        $c->add(RatingPeer::VISITOR_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->setDistinct();
        $this->recentjobs = JobPeer::doSelect($c);

        $c = new Criteria();
        $c->addDescendingOrderByColumn(UserJobPeer::CREATED_AT);
        $c->setLimit(5);
        $this->appliedujobs = $this->sesuser->getUserJobsByTypeId(UserJobPeer::UJTYP_APPLIED, false, $c);
    }
    
    public function handleError()
    {
    }
    
}
