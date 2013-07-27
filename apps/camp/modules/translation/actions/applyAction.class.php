<?php

class applyAction extends EmtAction
{
    public function initialize($context, $moduleName, $actionName)
    {
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
                    
                    $this->getUser()->setAttribute('new_company_data', $data, '\tx\translators\apply');
                    $this->getUser()->setAttribute('account', 'new_company', '\tx\translators\apply');
                    $this->redirect('@tr-apply?step=2');
                }
                elseif ($this->getRequestParameter('account') != '')
                {
                    $this->account = myTools::unplug($this->getRequestParameter('account'));
                    if ((($this->sesuser->getObjectTypeId() == $this->account->getObjectTypeId() && $this->sesuser->getId() == $this->account->getId()) ||
                        ($this->account->getObjectTypeId() != PrivacyNodeTypePeer::PR_NTYP_USER && $this->sesuser->isOwnerOf($this->account)))
                        && !(TranslatorPeer::retrieveAccountFor(array(TranslatorPeer::TR_STAT_APPROVED, TranslatorPeer::TR_STAT_PENDING, TranslatorPeer::TR_STAT_SUSPENDED), $this->account)))
                    {
                        $this->getUser()->setAttribute('account', $this->getRequestParameter('account'), '\tx\translators\apply');
                        $this->redirect('@tr-apply?step=2');
                    }
                    else
                    {
                        $this->redirect('@tr-apply');
                    }
                }
            }
            
            if ($this->step == 2)
            {
                $this->setTemplate('translatorProfile');

                $con = Propel::getConnection();

                if ($this->getUser()->getAttribute('account', null, '\tx\translators\apply') == 'new_company')
                {
                    $register_fields = $this->getUser()->getAttribute('new_company_data', null, '\tx\translators\apply');
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
                        ErrorLogPeer::Log($this->user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, 'Error while registering new company', $e);
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
                            ErrorLogPeer::Log($this->account->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, 'Error while creating email transaction for new company', $e);
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
                    $this->account = myTools::unplug($this->getUser()->getAttribute('account', null, '\tx\translators\apply'));
                    if (TranslatorPeer::retrieveAccountFor(array(TranslatorPeer::TR_STAT_APPROVED, TranslatorPeer::TR_STAT_PENDING, TranslatorPeer::TR_STAT_SUSPENDED), $this->account))
                    {
                        $this->redirect('@tr-apply');
                    }
                }
                
                try
                {
                    $con->beginTransaction();
                    
                    $this->translator = new Translator();
                    $this->translator->setHolderId($this->account->getId());
                    $this->translator->setHolderTypeId($this->account->getObjectTypeId());
                    $this->translator->setStatus(TranslatorPeer::TR_STAT_PENDING);
                    $this->translator->setDefaultLang($this->getUser()->getCulture());
                    $this->translator->save();
                    $this->translator->setName($this->account->__toString());
    
                    $sql = "INSERT INTO EMT_TRANSLATOR_I18N 
                            (id, culture, name, stripped_name, introduction)
                            VALUES
                            (:id, :culture, :name, :stripped_name, :introduction)
                    ";
    
                    $stmt = $con->prepare($sql);
                    $intro = $this->getRequestParameter('translator_introduction');
                    $stmt->bindValue(':id', $this->translator->getId());
                    $stmt->bindValue(':culture', $this->getUser()->getCulture());
                    $stmt->bindValue(':name', $this->translator->getName());
                    $stmt->bindValue(':stripped_name', $this->translator->getStrippedName());
                    $stmt->bindParam(':introduction', $intro, PDO::PARAM_STR, strlen($intro));
                    $stmt->execute();
                    
                    foreach ($this->getRequestParameter('langs') as $key => $lang)
                    {
                        $in = new TranslatorLanguage();
                        $in->setTranslatorId($this->translator->getId());
                        $in->setLanguage($lang);
                        $in->setNative($this->getRequestParameter('lang-'.$lang.'-native'));
                        $in->setLevelRead($this->getRequestParameter('lang-'.$lang.'-read'));
                        $in->setLevelWrite($this->getRequestParameter('lang-'.$lang.'-write'));
                        $in->setLevelSpeak($this->getRequestParameter('lang-'.$lang.'-speak'));
                        $in->save();
                    }

                    /*
                    $targets = $this->getRequestParameter('coup_targets');
                    $interprets = $this->getRequestParameter('coup_interprets');
                    $two_ways = $this->getRequestParameter('coup_two_ways');
                    foreach ($this->getRequestParameter('coup_sources') as $key => $source)
                    {
                        $mk = new TranslatorCouple();
                        $mk->setId($this->translator->getId());
                        $mk->setSourceLang($source);
                        $mk->setTargetLang($targets[$key]);
                        $mk->setCanInterpret($interprets[$key]);
                        $mk->setTwoWay($two_ways[$key]);
                        $mk->save();
                    }
                    */

                    $con->commit();
                }
                catch (Exception $e)
                {
                    $con->rollBack();
                    ErrorLogPeer::Log($this->account->getId(), $this->account->getObjectTypeId(), 'Error while creating translator application', $e);
                    $this->error = 'An error occured while creating your Translator application.';
                    return sfView::SUCCESS;
                }
                $i18n = $this->getContext()->getI18N();
                
                $this->getResponse()->setTitle($i18n->__('Translator Application Received | eMarketTurkey'));
                $this->setTemplate('applicationReceived');
            }
        }
        elseif ($this->step == 2)
        {
            if ($this->getUser()->getAttribute('account', null, '\tx\translators\apply') == 'new_company')
            {
                $data = $this->getUser()->getAttribute('new_company_data', null, '\tx\translators\apply');
                if (!$data)
                {
                    $this->getUser()->setAttribute('new_company_data', null, '\tx\translators\apply');
                    $this->getUser()->setAttribute('account', null, '\tx\translators\apply');
                    $this->redirect("@tr-apply");
                }
                $this->account = new Company();
                $this->account->setName($data->get('company_name'));
                $this->account->setSectorId($data->get('company_industry'));
                $this->account->setBusinessTypeId($data->get('company_bussiness_type'));
            }
            else
            {
                $this->account = myTools::unplug($this->getUser()->getAttribute('account', null, '\tx\translators\apply'), true);
                if (($this->sesuser->getObjectTypeId() == $this->account->getObjectTypeId() && $this->sesuser->getId() == $this->account->getId()) ||
                    ($this->account->getObjectTypeId() != PrivacyNodeTypePeer::PR_NTYP_USER && $this->sesuser->isOwnerOf($this->account)))
                {
                    $this->getUser()->setAttribute('account_type_id', $this->account->getObjectTypeId());
                    $this->getUser()->setAttribute('account_id', $this->account->getId());
                }
                else
                {
                    $this->redirect('@tr-apply');
                }
            }
            $this->setTemplate('translatorProfile');
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
            $this->getRequest()->removeError('translator_introduction');
            $this->getRequest()->removeError('langs');
            $this->getRequest()->removeError('tr_reads');
            $this->getRequest()->removeError('tr_writes');
            $this->getRequest()->removeError('tr_speaks');
            $this->getRequest()->removeError('tr_natives');
        }
        
        return !$this->getRequest()->hasErrors();
    }

}
