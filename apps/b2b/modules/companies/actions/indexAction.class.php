<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect("@camp.companies", 301);

        $this->net_companies = $this->sesuser->getConnections(PrivacyNodeTypePeer::PR_NTYP_COMPANY, null, true, true, 5, true);
        $this->featured_companies = CompanyPeer::getFeaturedCompanies(5);
    }
    
    public function handleError()
    {
    }
    
}
