<?php

class jobPositionAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        $act = $this->getRequestParameter('act');
        $isajax = $this->getRequest()->isXmlHttpRequest();
        $id = $this->getRequestParameter('id');
        
        if (is_numeric($id))
        {
            $this->jobPosition = JobPositionPeer::retrieveByPK($id);
            $token = md5($this->jobPosition->getName().$this->jobPosition->getId().session_id());

            if (!$this->jobPosition || 
                (!$isajax && $token!=$this->getRequestParameter('do')) ||
                ($isajax && $act!='rem' && $act!='tog'))
            {
                $this->redirect404();
            }
            
            if ($isajax)
            {
                if ($act == 'rem')
                {
                    $this->jobPosition->delete();
                    $this->redirect('admin/jobPositions');
                }
                elseif ($act == 'tog')
                {
                    $this->jobPosition->setActive(!$this->jobPosition->getActive());
                    $this->jobPosition->save();
                    return $this->renderPartial('admin/toggleItem', array('item' => $this->jobPosition, 'url' => 'admin/jobPosition', 'tabname' => 'jobpositions'));
                }
            }
            
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Job Position: %1', array('%1' => $this->jobPosition->getName())));
        }
        else
        {
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('New Job Position'));

            $this->jobPosition = new JobPosition();
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(JobPositionPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $this->jobPosition->setActive($this->getRequestParameter('jobposition_active'));
                $this->jobPosition->save();
                
                $pr = $this->getRequestParameter('languages');

                foreach($pr as $lang)
                {
                    $i18n = $this->jobPosition->getCurrentJobPositionI18n($lang);
                    
                    $i18n->setName($this->getRequestParameter('jobposition_name_'.$lang));
                    $i18n->save();
                }
                
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Job Position information has been saved successfully.', null, null, true);
                $this->redirect('admin/jobPositions');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new Job Position information. Please try again later.', null, null, false);
            }
        }
    }
    
    public function execute($request)
    {
         $result = $this->handleAction(false);
         if ($request->isXmlHttpRequest()) return $result;
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
            if ($this->getRequestParameter('jobposition_name_'.$lang)=='')
                $this->getRequest()->setError('jobposition_name_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter Job Position name for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
        }
        
        return !$this->getRequest()->hasErrors();
    }
}
