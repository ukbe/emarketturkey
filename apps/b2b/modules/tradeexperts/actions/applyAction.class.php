<?php

class applyAction extends EmtAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.tradeexperts-action?".http_build_query($params), 301);

        parent::initialize($context, $moduleName, $actionName);
        
        if ($this->sesuser->isNew()) $this->redirect('@myemt.login?_ref='.$this->getRequest()->getUri());
        
        $this->accounts = $this->sesuser->getCompanies(RolePeer::RL_CM_OWNER);
        array_unshift($this->accounts, $this->sesuser);
        $this->states = array();

        if ($country = CountryPeer::retrieveByISO($this->getRequestParameter('company_country')))
        {
            $this->states = GeonameCityPeer::getCitiesFor($country->getIso());
        }
        $this->step = myTools::fixInt($this->getRequestParameter('step'));
    }

    public function handleAction($isValidationError)
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            if ($this->step == 1)
            {
                if ($this->getRequestParameter('account') == 'new_company')
                {
                    $data = $this->getRequest()->getParameterHolder();
                    $this->account = new Company();
                    $this->account->setName($data->get('company_name'));
                    $this->account->setSectorId($data->get('company_industry'));
                    $this->account->setBusinessTypeId($data->get('company_bussiness_type'));
                    
                    $this->getUser()->setAttribute('new_company_data', $data, '\b2b\tradeexperts\apply');
                    $this->getUser()->setAttribute('account', 'new_company', '\b2b\tradeexperts\apply');
                    $this->setTemplate('tradeExpertsProfile');
                    return sfView::SUCCESS;
                }
                elseif ($this->getRequestParameter('account') != '')
                {
                    $this->account = myTools::unplug($this->getRequestParameter('account'));
                    if ((($this->sesuser->getObjectTypeId() == $this->account->getObjectTypeId() && $this->sesuser->getId() == $this->account->getId()) ||
                        ($this->account->getObjectTypeId() != PrivacyNodeTypePeer::PR_NTYP_USER && $this->sesuser->isOwnerOf($this->account)))
                        && !(TradeExpertPeer::retrieveAccountFor(array(TradeExpertPeer::TX_STAT_APPROVED, TradeExpertPeer::TX_STAT_PENDING, TradeExpertPeer::TX_STAT_SUSPENDED), $this->account)))
                    {
                        $this->getUser()->setAttribute('account', $this->getRequestParameter('account'), '\b2b\tradeexperts\apply');
                        $this->setTemplate('tradeExpertsProfile');
                        return sfView::SUCCESS;
                    }
                    else
                    {
                        $this->redirect('@tradeexperts-action?action=apply');
                    }
                }
            }
            
            if ($this->step == 2)
            {
                $this->setTemplate('tradeExpertsProfile');

                $con = Propel::getConnection();

                if ($this->getUser()->getAttribute('account', null, '\b2b\tradeexperts\apply') == 'new_company')
                {
                    $register_fields = $this->getUser()->getAttribute('new_company_data', null, '\b2b\tradeexperts\apply');
                    $register_fields->set('company_logins', array(RolePeer::RL_CM_OWNER => $this->sesuser));
                    $data = new sfParameterHolder();
                    
                    try
                    {
                        $con->beginTransaction();
                        
                        $this->account = CompanyPeer::Register($register_fields, &$data);
                        
                        $con->commit();
                    }
                    catch (Exception $e)
                    {
                        $con->rollBack();
                        ErrorLogPeer::Log($this->user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, 'Error while registering new company: '.$e->getMessage().'; File: '.$e->getFile().'; Line: '.$e->getLine());
                    }
                    
                    if ($this->account instanceof Company)
                    {
                        ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_CREATE_COMPANY, null, $this->account);
                        
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
                            ErrorLogPeer::Log($this->account->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, 'Error while creating email transaction for new company: '.$e->getMessage().'; File: '.$e->getFile().'; Line: '.$e->getLine());
                        }
                    }
                    else
                    {
                        $this->error = 'An error occured while registering new company.';
                        return sfView::SUCCESS;
                    }
                }
                else
                {
                    $this->account = myTools::unplug($this->getUser()->getAttribute('account', null, '\b2b\tradeexperts\apply'));
                    if (TradeExpertPeer::retrieveAccountFor(array(TradeExpertPeer::TX_STAT_APPROVED, TradeExpertPeer::TX_STAT_PENDING, TradeExpertPeer::TX_STAT_SUSPENDED), $this->account))
                    {
                        $this->redirect('@tradeexperts-action?action=apply');
                    }
                    
                }
                try
                {
                    $con->beginTransaction();
                    
                    $this->tradeexpert = new TradeExpert();
                    $this->tradeexpert->setHolderId($this->account->getId());
                    $this->tradeexpert->setHolderTypeId($this->account->getObjectTypeId());
                    $this->tradeexpert->setStatus(TradeExpertPeer::TX_STAT_PENDING);
                    $this->tradeexpert->save();
                    $this->tradeexpert->setName($this->account->__toString());
    
                    $sql = "INSERT INTO EMT_TRADE_EXPERT_I18N 
                            (id, culture, name, stripped_name, introduction)
                            VALUES
                            (:id, :culture, :name, :stripped_name, :introduction)
                    ";
    
                    $stmt = $con->prepare($sql);
                    $intro = $this->getRequestParameter('tradeexpert_introduction');
                    $stmt->bindValue(':id', $this->tradeexpert->getId());
                    $stmt->bindValue(':culture', $this->getUser()->getCulture());
                    $stmt->bindValue(':name', $this->tradeexpert->getName());
                    $stmt->bindValue(':stripped_name', $this->tradeexpert->getStrippedName());
                    $stmt->bindParam(':introduction', $intro, PDO::PARAM_STR, strlen($intro));
                    $stmt->execute();
                    
                    foreach ($this->getRequestParameter('tradeexpert_industries') as $ind)
                    {
                        $in = new TradeExpertIndustry();
                        $in->setId($this->tradeexpert->getId());
                        $in->setIndustryId($ind);
                        $in->save();
                    }
                    foreach ($this->getRequestParameter('tradeexpert_markets') as $mar)
                    {
                        $mk = new TradeExpertArea();
                        $mk->setId($this->tradeexpert->getId());
                        $mk->setCountry($mar);
                        $mk->save();
                    }

                    $con->commit();
                }
                catch (Exception $e)
                {
                    $con->rollBack();
                    ErrorLogPeer::Log($this->account->getId(), $this->account->getObjectTypeId(), 'Error while creating trade expert application: '.$e->getMessage().'; File: '.$e->getFile().'; Line: '.$e->getLine());
                    $this->error = 'An error occured while creating your Trade Experts application.';
                    return sfView::SUCCESS;
                }
                $i18n = $this->getContext()->getI18N();
                
                $this->getResponse()->setTitle($i18n->__('Trade Experts Application Received | eMarketTurkey'));
                $this->setTemplate('applicationReceived');
            }
        }
        elseif ($this->step == 2)
        {
            if ($this->getUser()->getAttribute('account', null, '\b2b\tradeexperts\apply') == 'new_company')
            {
                $data = $this->getRequest()->getParameterHolder();
                $this->account = new Company();
                $this->account->setName($data->get('company_name'));
                $this->account->setSectorId($data->get('company_industry'));
                $this->account->setBusinessTypeId($data->get('company_bussiness_type'));
            }
            else
            {
                $this->account = myTools::unplug($this->getUser()->getAttribute('account', null, '\b2b\tradeexperts\apply'), true);
                if (($this->sesuser->getObjectTypeId() == $this->account->getObjectTypeId() && $this->sesuser->getId() == $this->account->getId()) ||
                    ($this->account->getObjectTypeId() != PrivacyNodeTypePeer::PR_NTYP_USER && $this->sesuser->isOwnerOf($this->account)))
                {
                    $this->getUser()->setAttribute('account_type_id', $this->account->getObjectTypeId());
                    $this->getUser()->setAttribute('account_id', $this->account->getId());
                }
                else
                {
                    $this->redirect('@tradeexperts-action?action=apply');
                }
            }
            $this->setTemplate('tradeExpertsProfile');
        }
    }
    
    public function execute($request)
    {
         return $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {
        if ($this->getRequestParameter('account') != 'new_company')
        {
            $this->getRequest()->removeError('company_name');
            $this->getRequest()->removeError('company_industry');
            $this->getRequest()->removeError('company_business_type');
            $this->getRequest()->removeError('company_products');
            $this->getRequest()->removeError('company_introduction');
            $this->getRequest()->removeError('company_country');
            $this->getRequest()->removeError('company_state');
            $this->getRequest()->removeError('company_state');
            $this->getRequest()->removeError('company_street');
            $this->getRequest()->removeError('company_city');
            $this->getRequest()->removeError('company_postalcode');
            $this->getRequest()->removeError('company_phone');
        }
        
        if ($this->step != 1)
        {
            $this->getRequest()->removeError('account');
        }

        if ($this->step != 2)
        {
            $this->getRequest()->removeError('tradeexpert_industries');
            $this->getRequest()->removeError('tradeexpert_introduction');
            $this->getRequest()->removeError('tradeexpert_markets');
        }
        
        return !$this->getRequest()->hasErrors();
    }

}
