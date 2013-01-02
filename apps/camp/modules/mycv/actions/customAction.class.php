<?php

class customAction extends EmtCVAction
{

    private function handleAction($isValidationError)
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                $con = Propel::getConnection(ContactPeer::DATABASE_NAME);
                
                try
                {
                    $con->beginTransaction();

                    $this->resume->setSmokes($this->getRequestParameter('rsmc_smoke'));
                    $this->resume->setWillingToRelocate($this->getRequestParameter('rsmc_relocate'));
                    $this->resume->setWillingToTelecommute($this->getRequestParameter('rsmc_telecommute'));
                    $this->resume->setWillingToTravel($this->getRequestParameter('rsmc_travel'));
                    $this->resume->setDesiredSalary($this->getRequestParameter('rsmc_salary'));
                    $this->resume->setSalaryCurrency($this->getRequestParameter('rsmc_currency'));
                    $this->resume->setLicense(ResumePeer::RSM_LIC_POS_CAR, $this->getRequestParameter('rsmc_license_car'));
                    $this->resume->setLicense(ResumePeer::RSM_LIC_POS_MCYCLE, $this->getRequestParameter('rsmc_license_motorcycle'));
                    $this->resume->setLicense(ResumePeer::RSM_LIC_POS_BUS, $this->getRequestParameter('rsmc_license_bus'));
                    $this->resume->setLicense(ResumePeer::RSM_LIC_POS_TRUCK, $this->getRequestParameter('rsmc_license_truck'));
                    $this->resume->setMilitaryServiceStatus($this->getRequestParameter('rsmc_military_service') == ResumePeer::RSM_MILS_POSTPONED ? $this->getRequestParameter('rsmc_milser_postponed_year') : $this->getRequestParameter('rsmc_military_service'));
                    $this->resume->save();

                    $con->commit();
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    $this->redirect404();
                }
                
                if ($this->getRequestParameter('commit') == $this->getRequestParameter('next'))
                {
                    $this->redirect('@mycv-action?action=materials');
                }
                elseif ($this->getRequestParameter('commit') == $this->getRequestParameter('done'))
                {
                    $this->redirect('@mycv-action?action=review');
                }
            }
            else
            {
                // error, so display form again
                return sfView::SUCCESS;
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
