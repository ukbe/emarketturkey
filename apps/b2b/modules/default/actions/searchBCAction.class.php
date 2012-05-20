<?php

class searchBCAction extends EmtAction
{
    public function execute($request)
    {
        $within = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('within')), array(PrivacyNodeTypePeer::PR_NTYP_COMPANY, PrivacyNodeTypePeer::PR_NTYP_PRODUCT), null);
        

        $criteria = array();
        $criteria['keyword'] = $this->getRequestParameter('keyword');
        $criteria['country'] = $this->getRequestParameter('location');
        if ($within == PrivacyNodeTypePeer::PR_NTYP_COMPANY)
            $criteria['industry'] = $this->getRequestParameter('sector');
        elseif ($within == PrivacyNodeTypePeer::PR_NTYP_PRODUCT)
            $criteria['category'] = $this->getRequestParameter('category');

        $criteria = array_filter($criteria);
        
        $criteria = http_build_query($criteria);

        if ($within == PrivacyNodeTypePeer::PR_NTYP_COMPANY)
            $this->redirect('@search-companies' . ($criteria ? "?$criteria" : ''), 301);
        elseif ($within == PrivacyNodeTypePeer::PR_NTYP_PRODUCT)
            $this->redirect('@search-products' . ($criteria ? "?$criteria" : ''), 301);
        else
            $this->redirect404();
    }
    
}
