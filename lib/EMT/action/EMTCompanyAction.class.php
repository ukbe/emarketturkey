<?php

class EmtCompanyAction extends EmtAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->company = CompanyPeer::getCompanyFromUrl($this->getRequest()->getParameterHolder());

        if (!$this->company || $this->company->getOwner()->isBlocked()) $this->redirect404();

        $this->own_company = $this->sesuser->isOwnerOf($this->company);
        $this->profile = $this->company->getCompanyProfile();

        $this->getResponse()->addMeta('description', $this->profile->getIntroduction());

        $this->nums = array();
        $this->nums['followers'] = $this->company->countFollowers();
        $this->nums['products'] = $this->company->countActiveProducts();
        $this->nums['sleads'] = $this->company->countSellingLeads(null, true);
        $this->nums['bleads'] = $this->company->countBuyingLeads(null, true);
        $this->nums['jobs'] = $this->company->countOnlineJobs();
        $this->nums['events'] = $this->company->countEventsByPeriod(EventPeer::EVN_PRTYP_FUTURE);
        $this->nums['connections'] = $this->company->getConnections(null, array(RolePeer::RL_CM_PARTNER, RolePeer::RL_FOLLOWED_COMPANY, RolePeer::RL_GP_MEMBER), true, false, null, false, 0, null, array(), null, true);
    }
    
}