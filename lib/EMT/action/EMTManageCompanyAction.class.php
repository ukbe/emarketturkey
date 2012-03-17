<?php

class EmtManageCompanyAction extends EmtManageAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->company = CompanyPeer::getCompanyFromUrl($this->getRequest()->getParameterHolder());

        if (!$this->company) $this->redirect404();

        if (!$this->sesuser->isNew() && !$this->sesuser->getCompany($this->company->getId()))
        {
            $this->redirect('@homepage');
        }
    }
}