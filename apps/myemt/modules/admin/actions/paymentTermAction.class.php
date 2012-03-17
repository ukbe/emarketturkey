<?php

class paymentTermAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->paymentTerm = PaymentTermPeer::retrieveByPK($this->getRequestParameter('id'));

            if (!$this->paymentTerm || md5($this->paymentTerm->getName().$this->paymentTerm->getId().session_id())!=$this->getRequestParameter('do'))
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Payment Term: %1', array('%1' => $this->paymentTerm->getName())));
        }
        else
        {
            if ($this->getRequestParameter('act') == 'rem' ||
                $this->getRequestParameter('act') == 'tog')
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('New Payment Term'));

            $this->paymentTerm = new PaymentTerm();
        }
        
        if ($this->getRequestParameter('act') == 'rem')
        {
            $this->paymentTerm->delete();
            $this->redirect('admin/paymentTerms');
        }
        elseif ($this->getRequestParameter('act') == 'tog')
        {
            $this->paymentTerm->setActive(!$this->paymentTerm->getActive());
            $this->paymentTerm->save();
            $this->setTemplate('togglePaymentTerm');
            return sfView::SUCCESS;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(PaymentTermPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $this->paymentTerm->setCode($this->getRequestParameter('paymentterm_code'));
                $this->paymentTerm->save();
                
                $pr = $this->getRequestParameter('languages');

                foreach($pr as $lang)
                {
                    $i18n = $this->paymentTerm->getCurrentPaymentTermI18n($lang);
                    
                    $i18n->setName($this->getRequestParameter('paymentterm_name_'.$lang));
                    $i18n->setDescription($this->getRequestParameter('paymentterm_description_'.$lang));
                    $i18n->save();
                }
                
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Payment Term information has been saved successfully.', null, null, true);
                $this->redirect('admin/paymentTerms');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new Payment Term information. Please try again later.', null, null, false);
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
        $pr = $this->getRequestParameter('languages');
        $pr = is_array($pr)?$pr:array();
        
        foreach ($pr as $lang)
        {
            if ($this->getRequestParameter('paymentterm_name_'.$lang)=='')
                $this->getRequest()->setError('paymentterm_name_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter Payment Term name for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
            if ($this->getRequestParameter('paymentterm_description_'.$lang)=='')
                $this->getRequest()->setError('paymentterm_description_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter Payment Term description for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
        }
        
        return !$this->getRequest()->hasErrors();
    }
}
