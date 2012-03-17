<?php

class overviewAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        $this->active_products = $this->company->getActiveProducts();
        $this->pending_products = $this->company->getProductsByApprovalStatus(ProductPeer::PR_STAT_PENDING_APPROVAL);
        $this->must_edit_products = $this->company->getProductsByApprovalStatus(ProductPeer::PR_STAT_EDITING_REQUIRED);
    }
    
    public function handleError()
    {
    }
    
}
