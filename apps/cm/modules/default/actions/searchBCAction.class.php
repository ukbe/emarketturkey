<?php

class searchBCAction extends EmtAction
{
    public function execute($request)
    {
        $within = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('within')), array(PrivacyNodeTypePeer::PR_NTYP_USER, PrivacyNodeTypePeer::PR_NTYP_GROUP), null);

        $criteria = array();
        $criteria['keyword'] = $this->getRequestParameter('keyword');
        $criteria['country'] = $this->getRequestParameter('location');
        if ($within == PrivacyNodeTypePeer::PR_NTYP_GROUP)
            $criteria['type'] = $this->getRequestParameter('type');

        $criteria = array_filter($criteria);
        
        $criteria = http_build_query($criteria);

        if ($within == PrivacyNodeTypePeer::PR_NTYP_GROUP)
            $this->redirect('@search-groups' . ($criteria ? "?$criteria" : ''), 301);
        elseif ($within == PrivacyNodeTypePeer::PR_NTYP_USER)
            $this->redirect('@search-users' . ($criteria ? "?$criteria" : ''), 301);
        else
            $this->redirect404();
    }
    
}
