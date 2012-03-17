<?php

class importJobPositionsAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        $jobstr = $this->getRequestParameter('jobstr');
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(JobPositionPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();
                $jobs = explode(chr(13), $jobstr);
                foreach ($jobs as $job)
                {
                    if (trim($job)!='')
                    {
                        $j = new JobPosition();
                        $j->setActive(1);
                        $j->save();
                        $names = explode(',', $job);
                        
                        $i18n = $j->getCurrentJobPositionI18n('en');
                        $i18n->setName(trim($names[0]));
                        $i18n->save();
                        $i18n = $j->getCurrentJobPositionI18n('tr');
                        $i18n->setName(trim($names[1]));
                        $i18n->save();
                    }
                }

                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Job Position list has been imported successfully.', null, null, true);
                $this->redirect('admin/jobPositions');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while importing Job Position list. Please try again later. '.$e->getMessage(), null, null, false);
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
        return !$this->getRequest()->hasErrors();
    }
}
