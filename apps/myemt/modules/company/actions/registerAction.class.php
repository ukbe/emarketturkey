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

            $this->company = CompanyPeer::Register($register_fields, &$data);

            if ($this->company instanceof Company)
            {
                ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_CREATE_COMPANY, null, $this->company);
                
                $vars = array();
                $vars['email'] = $data->get('email');
                $vars['user_id'] = $data->get('user_id');
                $vars['data'] = $data;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_REGISTER_COMPANY;

                EmailTransactionPeer::CreateTransaction($vars);
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
            $this->contact_cities = GeonameCityPeer::getCitiesFor($this->getRequestParameter('company_country'));
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
            if (mb_strlen($this->getRequestParameter('company_name'), 'utf-8') < 3 || mb_strlen($this->getRequestParameter('company_name'), 'utf-8') > 255) $this->getRequest()->setError('company_name', 'Company Name should be 3 to 255 characters long.');
            if (mb_strlen($this->getRequestParameter('company_city'), 'utf-8') > 50) $this->getRequest()->setError('company_city', 'City/Town name should include maximum 50 characters.');
            if (mb_strlen($this->getRequestParameter('company_postalcode'), 'utf-8') > 10) $this->getRequest()->setError('company_postalcode', 'Postal Code should include maximum 10 characters.');
            if (mb_strlen($this->getRequestParameter('company_street'), 'utf-8') > 255) $this->getRequest()->setError('company_street', 'Street address should be maximum 255 characters long.');

            $pr = $this->getRequestParameter('company_lang');
            $pr = is_array($pr)?$pr:array();
            foreach ($pr as $key => $lang)
            {
                if ($lang == '')
                    $this->getRequest()->setError("company_lang_$key", sfContext::getInstance()->getI18N()->__('Please specify language'));
                if (mb_strlen($this->getRequestParameter("company_introduction_$key")) > 2000)
                    $this->getRequest()->setError("company_introduction_$key", sfContext::getInstance()->getI18N()->__('Company introduction for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 2000)));
                if (mb_strlen($this->getRequestParameter("company_productservice_$key")) > 2000)
                    $this->getRequest()->setError("company_productservice_$key", sfContext::getInstance()->getI18N()->__('Company products and services description for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 2000)));
            }
        }
        return !$this->getRequest()->hasErrors();
    }
}
