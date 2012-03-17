<?php

class serviceAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->service = ServicePeer::retrieveByPK($this->getRequestParameter('id'));

            if (!$this->service || md5($this->service->getName().$this->service->getId().session_id())!=$this->getRequestParameter('do'))
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Service: %1', array('%1' => $this->service->getName())));
        }
        else
        {
            if ($this->getRequestParameter('act') == 'rem' ||
                $this->getRequestParameter('act') == 'tog')
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('New Service'));

            $this->service = new Service();
        }
        
        if ($this->getRequestParameter('act') == 'rem')
        {
            $this->service->delete();
            $this->redirect('admin/services');
        }
        elseif ($this->getRequestParameter('act') == 'tog')
        {
            $this->service->setActive(!$this->service->getActive());
            $this->service->save();
            $this->setTemplate('toggleService');
            return sfView::SUCCESS;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(ServicePeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $this->service->setApplicationId($this->getRequestParameter('application_id'));
                $this->service->setAppliesToTypeId($this->getRequestParameter('applies_to_id'));
                $this->service->setActive($this->getRequestParameter('service_active'));
                $this->service->save();
                
                $pr = $this->getRequestParameter('languages');

                foreach($pr as $lang)
                {
                    $i18n = $this->service->getCurrentServiceI18n($lang);
                    
                    $i18n->setName($this->getRequestParameter('service_name_'.$lang));
                    $i18n->save();
                }
                
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Service information has been saved successfully.', null, null, true);
                $this->redirect('admin/services');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new Service information. Please try again later.', null, null, false);
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
            if ($this->getRequestParameter('service_name_'.$lang)=='')
                $this->getRequest()->setError('service_name_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter Business Type name for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
        }
        
        return !$this->getRequest()->hasErrors();
    }
}
