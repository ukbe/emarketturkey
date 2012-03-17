<?php

class applicationAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->application = ApplicationPeer::retrieveByPK($this->getRequestParameter('id'));

            if (!$this->application || md5($this->application->getName().$this->application->getId().session_id())!=$this->getRequestParameter('do'))
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Application: %1', array('%1' => $this->application->getName())));
        }
        else
        {
            if ($this->getRequestParameter('act') == 'rem' ||
                $this->getRequestParameter('act') == 'tog')
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('New Application'));

            $this->application = new Application();
        }
        
        if ($this->getRequestParameter('act') == 'rem')
        {
            $this->application->delete();
            $this->redirect('admin/applications');
        }
        elseif ($this->getRequestParameter('act') == 'tog')
        {
            $this->application->setActive(!$this->application->getActive());
            $this->application->save();
            $this->setTemplate('toggleApplication');
            return sfView::SUCCESS;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(ApplicationPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $this->application->setAppCode($this->getRequestParameter('application_appcode'));
                //$this->application->setActive($this->getRequestParameter('application_active'));
                $this->application->save();
                
                $pr = $this->getRequestParameter('languages');

                foreach($pr as $lang)
                {
                    $i18n = $this->application->getCurrentApplicationI18n($lang);
                    
                    $i18n->setName($this->getRequestParameter('application_name_'.$lang));
                    $i18n->save();
                }
                
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Application information has been saved successfully.', null, null, true);
                $this->redirect('admin/applications');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new Application information. Please try again later.', null, null, false);
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
            if ($this->getRequestParameter('application_name_'.$lang)=='')
                $this->getRequest()->setError('application_name_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter Business Type name for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
        }
        
        return !$this->getRequest()->hasErrors();
    }
}
