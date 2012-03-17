<?php

class manageAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        $this->leads = Array();
        $this->leads[B2bLeadPeer::B2B_LEAD_BUYING] = $this->company->getBuyingLeads();
        $this->leads[B2bLeadPeer::B2B_LEAD_SELLING] = $this->company->getSellingLeads();
        return sfView::SUCCESS;
    }
    
    public function handleError()
    {
    }
    
}
