<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $this->featured_groups = GroupPeer::getFeaturedGroups(5);
        $this->net_groups = $this->sesuser->getConnections(PrivacyNodeTypePeer::PR_NTYP_GROUP, null, true, true, 5, true);

    }

    public function handleError()
    {
    }

}
