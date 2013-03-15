<?php

class addCompanyAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        $this->contact_cities = array();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $userdata = new sfParameterHolder();
            $compdata = new sfParameterHolder();
            $company = null;
            
            $con = Propel::getConnection(UserPeer::DATABASE_NAME);
            $con->beginTransaction();
            
            // USER REGISTRATION
            $signup_fields = $this->getRequest()->getParameterHolder();
            $signup_fields->set('bd_day', date('d'));
            $signup_fields->set('bd_month', date('m'));
            $signup_fields->set('bd_year', date('Y'));
            $signup_fields->set('reminder_question', '0000');
            $signup_fields->set('reminder_answer', '0000');
            $user = UserPeer::SignupUser($signup_fields, &$userdata);

            if ($user instanceof User)
            {
                // COMPANY REGISTRATION
                $register_fields = $this->getRequest()->getParameterHolder();
                $data = new sfParameterHolder();
                $register_fields->set('company_logins', array(RolePeer::RL_CM_OWNER => $user,
                                                              RolePeer::RL_CM_REPRESENTATIVE => $this->user));
                
                $company = CompanyPeer::Register($register_fields, &$compdata);
            }
            
            if ($user instanceof User && $company instanceof Company)
            {
                $con->commit();
                
                // Send Signup Email
                $vars = array();
                $vars['email'] = $userdata->get('email');
                $vars['user_id'] = $userdata->get('user_id');
                $vars['data'] = $userdata;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_SIGNUP;

                EmailTransactionPeer::CreateTransaction($vars);

                // Send Company Registration Email
                $vars = array();
                $vars['email'] = $compdata->get('email');
                $vars['user_id'] = $compdata->get('user_id');
                $vars['data'] = $compdata;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_REGISTER_COMPANY;

                EmailTransactionPeer::CreateTransaction($vars);
            }
            else
            {
                $con->rollBack();
                ErrorLogPeer::Log($this->user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, "Error while adding portfolio company.", null);

                $this->errorWhileSaving = true;
                return sfView::SUCCESS;
            }
            
            $this->redirect("representative/company?id=".$company->getId());
        }

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->contact_cities = GeonameCityPeer::getCitiesFor($this->getRequestParameter('comp_country'));
        }

        return sfView::SUCCESS;
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
        return !$this->getRequest()->hasErrors();
    }
}
