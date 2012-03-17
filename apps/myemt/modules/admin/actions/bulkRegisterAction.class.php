<?php

class bulkRegisterAction extends EmtAction
{
    public function handleAction($isValidationError)
    {

        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(JobPositionPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $con->commit();
                $this->getUser()->setMessage('Process Complete!', 'Registration process was completed successfully.', null, null, true);
                $this->redirect('admin/bulkRegister');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while bulk-registration process. Please see the error message below:<br />'.$e->getMessage(), null, null, false);
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
