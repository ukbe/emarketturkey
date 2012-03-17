<?php

class addServicesAction extends EmtManageJobAction
{
    public function handleAction($isValidationError)
    {
        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("Select Services for '%1'", array('%1' => $this->job->getTitle())));

        $this->services = array(ServicePeer::STYP_JOB_SPOT_LISTING      => ServicePeer::retrieveByPK(ServicePeer::STYP_JOB_SPOT_LISTING),
                                ServicePeer::STYP_JOB_PLATINUM_LISTING  => ServicePeer::retrieveByPK(ServicePeer::STYP_JOB_PLATINUM_LISTING),);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection();

            try
            {
                $con->beginTransaction();
                
                if ($this->getRequestParameter('job_function') != '')
                    $this->job->addSpec(JobSpecPeer::JSPTYP_JOB_FUNCTION, $this->getRequestParameter('job_function')); 

                $con->commit();
                $this->redirect($this->otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "@company-jobs-action?action=list&hash={$this->own}" : "@group-jobs-action?action=list&hash={$this->own}");
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing job location information. Please try again later.'.$e->getMessage(), null, null, false);
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