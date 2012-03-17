<?php

class registerAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->contact_cities = array();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $register_fields = $this->getRequest()->getParameterHolder();
            $register_fields->set('company_logins', array(RolePeer::RL_CM_OWNER => $this->getUser()->getUser()));
            $data = new sfParameterHolder();
            
            $con = Propel::getConnection(CompanyPeer::DATABASE_NAME);
            try
            {
                $con->beginTransaction();
                
                $this->company = CompanyPeer::Register($register_fields, &$data);
                
                $con->commit();
            }
            catch (Exception $e)
            {
                $con->rollBack();
                ErrorLogPeer::Log($this->user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, 'Error while registering new company: '.$e->getMessage().'; File: '.$e->getFile().'; Line: '.$e->getLine());
            }
            
            if ($this->company instanceof Company)
            {
                ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_CREATE_COMPANY, null, $this->company);
                
                $vars = array();
                $vars['email'] = $data->get('email');
                $vars['user_id'] = $data->get('user_id');
                $vars['data'] = $data;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_REGISTER_COMPANY;

                try
                {
                    EmailTransactionPeer::CreateTransaction($vars);
                }
                catch (Exception $e)
                {
                    ErrorLogPeer::Log($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, 'Error while creating email transaction for new company: '.$e->getMessage().'; File: '.$e->getFile().'; Line: '.$e->getLine());
                }
            }
            else
            {
                $this->errorWhileSaving = true;
                return sfView::SUCCESS;
            }
            
            $keepon = $this->getRequestParameter('keepon');
            $this->redirect($keepon != '' ? $keepon : "@company-route?hash={$this->company->getHash()}");
        }
        elseif ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->contact_cities = GeonameCityPeer::getCitiesFor($this->getRequestParameter('comp_country'));
        }
        else
        {
            return sfView::SUCCESS;
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (mb_strlen($this->getRequestParameter('comp_name'), 'utf-8') < 3 || mb_strlen($this->getRequestParameter('comp_name'), 'utf-8') > 255) $this->getRequest()->setError('comp_name', 'Company Name should be 3 to 255 characters long.');
            if (mb_strlen($this->getRequestParameter('comp_introduction'), 'utf-8') > 1000) $this->getRequest()->setError('comp_introduction', 'Company Introduction should include maximum 1000 characters.');
            if (mb_strlen($this->getRequestParameter('comp_productservices'), 'utf-8') > 1000) $this->getRequest()->setError('comp_productservices', 'Products and Services should include maximum 1000 characters.');
            if (mb_strlen($this->getRequestParameter('comp_city'), 'utf-8') > 50) $this->getRequest()->setError('comp_city', 'City/Town Name should include maximum 50 characters.');
            if (mb_strlen($this->getRequestParameter('comp_postalcode'), 'utf-8') > 10) $this->getRequest()->setError('comp_postalcode', 'Postal Code should include maximum 10 characters.');
        }
        return !$this->getRequest()->hasErrors();
    }
}
