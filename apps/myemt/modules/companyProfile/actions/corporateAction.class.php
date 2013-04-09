<?php

class corporateAction extends EmtManageCompanyAction
{
    public function handleAction($isValidationError)
    {
        $this->profile = $this->company->getCompanyProfile();
        if ($this->profile) $this->contact = $this->profile->getContact();
        else $this->profile = new CompanyProfile();
        
        if ($this->contact)
        {
            $this->work_address = $this->contact->getWorkAddress();
            $this->work_phone = $this->contact->getWorkPhone(); 
        }
        
        if (!$this->work_address) $this->work_address = new ContactAddress();
        if (!$this->work_phone) $this->work_phone = new ContactPhone();
        $this->i18ns = $this->profile->getExistingI18ns();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(CompanyPeer::DATABASE_NAME);
    
            try
            {
                $con->beginTransaction();
                
                $pr = $this->getRequestParameter('comp_lang');
                
                $this->company->setName($this->getRequestParameter('company_name'));
                $this->company->setBusinessTypeId($this->getRequestParameter('business_type'));
                $this->company->setSectorId($this->getRequestParameter('business_sector'));
                $this->profile->setNoOfQcStaff($this->getRequestParameter('qc_staff'));
                $this->profile->setNoOfRdStaff($this->getRequestParameter('rd_staff'));
                $this->profile->setNoOfEmployees($this->getRequestParameter('employees'));
                $this->profile->setNoOfProdLine($this->getRequestParameter('prod_line'));
                $this->profile->setCertifications($this->getRequestParameter('certifications'));
                $this->profile->setFactorySize($this->getRequestParameter('factory_size'));
                $this->profile->setFactorySizeUnit($this->getRequestParameter('factory_size_unit'));
                $this->profile->setExportPercentSpan($this->getRequestParameter('export_percent_span'));
                $this->profile->setFoundedIn($this->getRequestParameter('founded_in'));
                $this->profile->save();
                $this->company->setProfileId($this->profile->getId());
                
                if (is_array($pr))
                {
                    foreach($pr as $key => $lang)
                    {
                        if ($this->profile->hasLsiIn($lang))
                        {
                            $sql = "UPDATE EMT_COMPANY_PROFILE_I18N 
                        			SET id=:id, culture=:culture, introduction=:introduction, product_service=:product_service
                        			WHERE id=:id AND culture=:culture
                            ";
                        }
                        else
                        {
                            $sql = "INSERT INTO EMT_COMPANY_PROFILE_I18N 
                                    (id, culture, introduction, product_service)
                                    VALUES
                                    (:id, :culture, :introduction, :product_service)
                            ";
                        }
                        
                        $stmt = $con->prepare($sql);
                        $c_intro = $this->getRequestParameter("introduction_$key");
                        $c_prod = $this->getRequestParameter("productservice_$key");
                        $stmt->bindValue(':id', $this->profile->getId());
                        $stmt->bindValue(':culture', $lang);
                        $stmt->bindParam(':introduction', $c_intro, PDO::PARAM_STR, strlen($c_intro));
                        $stmt->bindParam(':product_service', $c_prod, PDO::PARAM_STR, strlen($c_prod));
                        $stmt->execute();
                    }
                }
                if (!$this->profile->isNew() && count($diff = array_diff($this->i18ns, $pr))) $this->profile->removeI18n($diff);
                
                $this->company->save();
                
                ActionLogPeer::Log($this->company, ActionPeer::ACT_UPDATE_CORPORATE_INFO);
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Company information has been saved successfully.', null, null, true);
                $this->redirect("@edit-company-profile?hash={$this->company->getHash()}");
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing company information. Please try again later.', null, null, false);
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function validate()
    {
        $pr = $this->getRequestParameter('comp_lang');
        $pr = is_array($pr)?$pr:array();
        foreach ($pr as $key => $lang)
        {
            if ($lang == '')
                $this->getRequest()->setError("comp_lang_$key", sfContext::getInstance()->getI18N()->__('Please specify language'));
            if (mb_strlen($this->getRequestParameter("introduction_$key")) > 5000)
                $this->getRequest()->setError("introduction_$key", sfContext::getInstance()->getI18N()->__('Company introduction for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 5000)));
            if (mb_strlen($this->getRequestParameter("productservice_$key")) > 5000)
                $this->getRequest()->setError("productservice_$key", sfContext::getInstance()->getI18N()->__('Company products and services description for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 5000)));
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}