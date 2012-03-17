<?php

class relationsAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->act = myTools::pick_from_list($this->getRequestParameter('act'), array('add', 'remove'), null);
        switch ($this->act)
        {
            case 'add':
                $this->typ = myTools::pick_from_list($this->getRequestParameter('typ'), array('parent', 'subsidiary'), null);
                if ($this->typ)
                {
                    $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__($this->typ=='parent' ? 'Add Parent Company | eMarketTurkey' : 'Add Subsidiary Company | eMarketTurkey'));
                }
                $this->company_id = myTools::fixInt($this->getRequestParameter('company_id'));
                
                $this->rlcomp = $this->company_id && !$this->company->getCompanyUserFor($this->company_id, PrivacyNodeTypePeer::PR_NTYP_COMPANY, null, array(CompanyUserPeer::CU_STAT_PENDING_CONFIRMATION, CompanyUserPeer::CU_STAT_ACTIVE)) ? CompanyPeer::retrieveByPK($this->company_id) : null;

                if ($this->company_id && !$this->rlcomp) $this->company_id = null;
                
                $this->keyword = $this->getRequestParameter('relation_keyword');
                
                $this->setTemplate('addRelation');
                break;
            case 'remove':
                $rarr = array('parent' => RolePeer::RL_CM_PARENT_COMPANY, 'subsidiary' => RolePeer::RL_CM_SUBSIDIARY_COMPANY);
                $role = myTools::pick_from_list($this->getRequestParameter('rel'), array_keys($rarr));
                $cid = myTools::fixInt($this->getRequestParameter('cid'));
                if ($role || $cid)
                {
                    $relation = $this->company->getCompanyUserFor($cid, PrivacyNodeTypePeer::PR_NTYP_COMPANY, $rarr[$role], array(CompanyUserPeer::CU_STAT_ACTIVE, CompanyUserPeer::CU_STAT_PENDING_CONFIRMATION));
                    if ($relation)
                    {

                        $relation->setStatus($this->company->getId() == $relation->getCompanyId() ? CompanyUserPeer::CU_STAT_ENDED_BY_STARTER_USER : CompanyUserPeer::CU_STAT_ENDED_BY_TARGET_USER);
                        $relation->save();
                    }
                }
                $this->redirect("@company-account?action=relations&hash={$this->company->getHash()}");
                break;
        }

        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            if (!$this->company_id && $this->keyword)
            {
                $c = new Criteria();
                $c->add(CompanyPeer::NAME, "UPPER(EMT_COMPANY.NAME) LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
                $c->setLimit(20);
                $this->companies = CompanyPeer::doSelect($c);
                $this->setTemplate('selectRelationCompany');
            }

            $rm = array('parent' => RolePeer::RL_CM_PARENT_COMPANY,
                        'subsidiary' => RolePeer::RL_CM_SUBSIDIARY_COMPANY);

            if ($this->rlcomp && !$this->company->getCompanyUserFor($this->rlcomp->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, null, array(CompanyUserPeer::CU_STAT_PENDING_CONFIRMATION, CompanyUserPeer::CU_STAT_ACTIVE)))
            {
                $new = new CompanyUser();
                $new->setCompanyId($this->company->getId());
                $new->setObjectId($this->rlcomp->getId());
                $new->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_COMPANY);
                $new->setRoleId($rm[$this->getRequestParameter('typ')]);
                $new->setStatus(CompanyUserPeer::CU_STAT_PENDING_CONFIRMATION);
                $new->save();
                $this->redirect("@company-account?action=relations&hash={$this->company->getHash()}");
            }
            
        }

        $this->parents = $this->company->getPartners(null, RolePeer::RL_CM_PARENT_COMPANY, array(CompanyUserPeer::CU_STAT_ACTIVE, CompanyUserPeer::CU_STAT_PENDING_CONFIRMATION));
        $this->subsidiaries = $this->company->getPartners(null, RolePeer::RL_CM_SUBSIDIARY_COMPANY, array(CompanyUserPeer::CU_STAT_ACTIVE, CompanyUserPeer::CU_STAT_PENDING_CONFIRMATION));
    }
    
    public function validate()
    {
        if ($this->getRequestParameter('search_email') == $this->sesuser->getLogin()->getEmail())
            $this->getRequest()->setError('search_email', 'E-mail address is invalid.');
        
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}