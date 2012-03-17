<?php

class businessTypeAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->businessType = BusinessTypePeer::retrieveByPK($this->getRequestParameter('id'));

            if (!$this->businessType || md5($this->businessType->getName().$this->businessType->getId().session_id())!=$this->getRequestParameter('do'))
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Business Type: %1', array('%1' => $this->businessType->getName())));
        }
        else
        {
            if ($this->getRequestParameter('act') == 'rem' ||
                $this->getRequestParameter('act') == 'tog')
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('New Business Type'));

            $this->businessType = new BusinessType();
        }
        
        if ($this->getRequestParameter('act') == 'rem')
        {
            $this->businessType->delete();
            $this->redirect('admin/businessTypes');
        }
        elseif ($this->getRequestParameter('act') == 'tog')
        {
            $this->businessType->setActive(!$this->businessType->getActive());
            $this->businessType->save();
            $this->setTemplate('toggleBusinessType');
            return sfView::SUCCESS;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(BusinessTypePeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $this->businessType->setActive($this->getRequestParameter('businesstype_active'));
                $this->businessType->save();
                
                $pr = $this->getRequestParameter('languages');

                foreach($pr as $lang)
                {
                    $i18n = $this->businessType->getCurrentBusinessTypeI18n($lang);
                    
                    $i18n->setName($this->getRequestParameter('businesstype_name_'.$lang));
                    $i18n->save();
                }
                
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Business Type information has been saved successfully.', null, null, true);
                $this->redirect('admin/businessTypes');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new Business Type information. Please try again later.', null, null, false);
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
            if ($this->getRequestParameter('businesstype_name_'.$lang)=='')
                $this->getRequest()->setError('businesstype_name_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter Business Type name for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
        }
        
        return !$this->getRequest()->hasErrors();
    }
}
