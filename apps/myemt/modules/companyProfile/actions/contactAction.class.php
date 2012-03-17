<?php

class contactAction extends EmtManageCompanyAction
{
    public function handleAction($isValidationError)
    {
        $this->profile = $this->company->getCompanyProfile();
        if ($this->profile) $this->contact = $this->profile->getContact();
        
        if ($this->contact)
        {
            $this->work_address = $this->contact->getWorkAddress();
            $this->work_phone = $this->contact->getWorkPhone(); 
            $this->fax_number = $this->contact->getPhoneByType(ContactPeer::FAX);
        }
        
        if (!$this->work_address) $this->work_address = new ContactAddress();
        if (!$this->work_phone) $this->work_phone = new ContactPhone();
        if (!$this->fax_number) $this->fax_number = new ContactPhone();

        if ($this->work_address->getCountry())
            $this->contact_cities = GeonameCityPeer::getCitiesFor($this->work_address->getCountry());
        else
            $this->contact_cities = array();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            
            $con = Propel::getConnection(CompanyPeer::DATABASE_NAME);
            try
            {
                $con->beginTransaction();
                
                if ($this->contact->isNew())
                {
                    $this->contact->setEmail($this->sesuser->getLogin()->getEmail());
                    $this->contact->save();
                    $this->profile->setContactId($this->contact->getId());
                    $this->profile->save();
                }

                if ($this->profile->isNew())
                {
                    $this->company->setProfileId($this->profile->getId());
                }
                $this->company->setUrl($this->getRequestParameter('web_url'));
                $this->company->save();

                $this->work_address->setCountry($this->getRequestParameter('work_country'));
                $this->work_address->setStreet($this->getRequestParameter('work_street'));
                $this->work_address->setCity($this->getRequestParameter('work_city'));
                $this->work_address->setPostalCode($this->getRequestParameter('work_postalcode'));
                $this->work_address->setState($this->getRequestParameter('work_state'));
                $this->work_address->setContactId($this->contact->getId());
                $this->work_address->setType(ContactPeer::WORK);
                $this->work_address->save();

                $this->work_phone->setPhone($this->getRequestParameter('work_phone'));
                $this->work_phone->setType(ContactPeer::WORK);
                $this->work_phone->setContactId($this->contact->getId());
                $this->work_phone->save();

                $this->fax_number->setPhone($this->getRequestParameter('fax_number'));
                $this->fax_number->setType(ContactPeer::FAX);
                $this->fax_number->setContactId($this->contact->getId());
                $this->fax_number->save();
                
                ActionLogPeer::Log($this->company, ActionPeer::ACT_UPDATE_CONTACT_INFO);
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Company information has been saved successfully.', null, null, true);
                $this->redirect("@edit-company-profile?hash={$this->company->getHash()}");
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing company information. Please try again later.'.$e->getMessage(), null, null, false);
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}