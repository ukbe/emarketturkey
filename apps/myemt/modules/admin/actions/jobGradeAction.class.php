<?php

class jobGradeAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        $act = $this->getRequestParameter('act');
        $isajax = $this->getRequest()->isXmlHttpRequest();
        $id = $this->getRequestParameter('id');
        
        if (is_numeric($id))
        {
            $this->jobGrade = JobGradePeer::retrieveByPK($id);
            $token = md5($this->jobGrade->getName().$this->jobGrade->getId().session_id());

            if (!$this->jobGrade || 
                (!$isajax && $token!=$this->getRequestParameter('do')) ||
                ($isajax && $act!='rem' && $act!='tog'))
            {
                $this->redirect404();
            }
            
            if ($isajax)
            {
                if ($act == 'rem')
                {
                    $this->jobGrade->delete();
                    $this->redirect('admin/jobGrades');
                }
                elseif ($act == 'tog')
                {
                    $this->jobGrade->setActive(!$this->jobGrade->getActive());
                    $this->jobGrade->save();
                    return $this->renderPartial('admin/toggleItem', array('item' => $this->jobGrade, 'url' => 'admin/jobGrade', 'tabname' => 'jobgrades'));
                }
            }
            
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Job Grade: %1', array('%1' => $this->jobGrade->getName())));
        }
        else
        {
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('New Job Grade'));

            $this->jobGrade = new JobGrade();
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(JobGradePeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $this->jobGrade->setActive($this->getRequestParameter('jobgrade_active'));
                $this->jobGrade->save();
                
                $pr = $this->getRequestParameter('languages');

                foreach($pr as $lang)
                {
                    $i18n = $this->jobGrade->getCurrentJobGradeI18n($lang);
                    
                    $i18n->setName($this->getRequestParameter('jobgrade_name_'.$lang));
                    $i18n->save();
                }
                
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Job Grade information has been saved successfully.', null, null, true);
                $this->redirect('admin/jobGrades');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new Job Grade information. Please try again later.', null, null, false);
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
            if ($this->getRequestParameter('jobgrade_name_'.$lang)=='')
                $this->getRequest()->setError('jobgrade_name_'.$lang, sfContext::getInstance()->getI18N()->__('Please enter Job Grade name for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
        }
        
        return !$this->getRequest()->hasErrors();
    }
}
