<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class companiesAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        $this->filter = $this->getRequestParameter('filter');
        
        $table = new EmtAjaxTable('companies');
        $c = new Criteria();
        $c->addJoin(CompanyUserPeer::COMPANY_ID, CompanyPeer::ID, Criteria::INNER_JOIN);
        $c->add(CompanyUserPeer::OBJECT_ID, $this->user->getId());
        $c->add(CompanyUserPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
        $c->add(CompanyUserPeer::ROLE_ID, RolePeer::RL_CM_REPRESENTATIVE);

        if ($this->getRequest()->hasParameter('sort')) $table->setOrderColumn($this->getRequestParameter('sort'));
        if ($this->getRequest()->hasParameter('dir')) $table->setSortOrder($this->getRequestParameter('dir'));
        $table->setKeyword($this->filter);
        $table->init($c);

        $this->table = $table;
        
        if ($this->getRequestParameter('act') == 'ret')
        {
            $this->setTemplate('retrieveCompanies');
            $this->setLayout(false);
        }
        
        return sfView::SUCCESS;
    }

    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}