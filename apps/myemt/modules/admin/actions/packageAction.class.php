<?php

class packageAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->package = MarketingPackagePeer::retrieveByPK($this->getRequestParameter('id'));

            if (!$this->package || md5($this->package->getName().$this->package->getId().session_id())!=$this->getRequestParameter('do'))
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Marketing Package: %1', array('%1' => $this->package->getName())));
        }
        else
        {
            if ($this->getRequestParameter('act') == 'rem' ||
                $this->getRequestParameter('act') == 'tog')
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('New Marketing Package'));

            $this->package = new MarketingPackage();
        }
        
        if ($this->getRequestParameter('act') == 'rem')
        {
            $this->package->delete();
            $this->redirect('admin/packages');
        }
        elseif ($this->getRequestParameter('act') == 'tog')
        {
            $this->package->setActive(!$this->package->getActive());
            $this->package->save();
            $this->setTemplate('toggleMarketingPackage');
            return sfView::SUCCESS;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(MarketingPackagePeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $this->package->setApplicationId($this->getRequestParameter('application_id'));
                $this->package->setAppliesToTypeId($this->getRequestParameter('applies_to_id'));
                $this->package->setValidFrom($this->getRequestParameter('valid_from_year').'-'.
                    $this->getRequestParameter('valid_from_month').'-'.
                    $this->getRequestParameter('valid_from_day'));
                $this->package->setValidTo($this->getRequestParameter('valid_to_year').'-'.
                    $this->getRequestParameter('valid_to_month').'-'.
                    $this->getRequestParameter('valid_to_day'));
                $this->package->setActive($this->getRequestParameter('package_active'));
                $this->package->setStatus($this->getRequestParameter('package_status'));
                $this->package->save();
                
                $pr = $this->getRequestParameter('languages');

                foreach($pr as $lang)
                {
                    $i18n = $this->package->getCurrentMarketingPackageI18n($lang);
                    
                    $i18n->setName($this->getRequestParameter('package_name_'.$lang));
                    $i18n->setDescription($this->getRequestParameter('package_description_'.$lang));
                    $i18n->save();
                }
                
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Marketing Package information has been saved successfully.', null, null, true);
                $this->redirect('admin/packages');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new Marketing Package information. Please try again later.', null, null, false);
            }
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
        if ($this->getRequest()->getMethod()==sfRequest::POST && ($this->getRequestParameter('valid_from_day')=='' || $this->getRequestParameter('valid_from_month')=='' || $this->getRequestParameter('valid_from_year')==''))
        {
            $this->getRequest()->setError('valid_from_day', 'Please specify a Valid From date for this package.');
        }
        
        $pr = $this->getRequestParameter('languages');
        $pr = is_array($pr)?$pr:array();
        
        foreach ($pr as $lang)
        {
            if ($this->getRequestParameter('package_name_'.$lang)=='')
                $this->getRequest()->setError('package_name_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter Business Type name for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
        }
        
        return !$this->getRequest()->hasErrors();
    }
}
