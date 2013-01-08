<?php

class attendersAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.events-action?".http_build_query($params), 301);

        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->industry = null; //is_numeric($this->getRequestParameter('industry')) ? BusinessSectorPeer::retrieveByPK($this->getRequestParameter('industry')) : null;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('country')) : '';

        $joins = $wheres = array();

        $joins[] = "LEFT JOIN EMT_EVENT ON EMT_EVENT_INVITE.EVENT_ID=EMT_EVENT.ID";
        $joins[] = "LEFT JOIN EMT_TIME_SCHEME ON EMT_EVENT.TIME_SCHEME_ID=EMT_TIME_SCHEME.ID";

        $wheres[] = "TRUNC(EMT_TIME_SCHEME.END_DATE) >= TRUNC(SYSDATE)";

        $this->pager = $this->sesuser->getConnections(null, null, true, true, null, false, 20, $this->page, array('joins' => $joins, 'wheres' => $wheres), PrivacyNodeTypePeer::PR_NTYP_EVENT_INVITE);
    }

    public function handleError()
    {
    }

}
