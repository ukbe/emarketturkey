<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $this->net_people = $this->sesuser->getConnections(PrivacyNodeTypePeer::PR_NTYP_USER, null, true, true, 5, true);
        $this->pmyk_people = $this->sesuser->getSuggestedFriendsPager(2, true, 5, null, false);

    }

    public function handleError()
    {
    }

}
