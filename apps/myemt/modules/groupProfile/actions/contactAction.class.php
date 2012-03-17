<?php

class contactAction extends EmtManageGroupAction
{
    protected $actionID = ActionPeer::ACT_UPDATE_CONTACT_INFO;
      
    public function handleAction($isValidationError)
    {
        $this->contact = $this->group->getContact();

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
            
            $con = Propel::getConnection(GroupPeer::DATABASE_NAME);
            try
            {
                $con->beginTransaction();
                
                if ($this->contact->isNew())
                {
                    $this->contact->setEmail($this->getRequestParameter('group_email'));
                    $this->contact->save();
                    $this->group->setContactId($this->contact->getId());
                    $this->group->save();
                }
                else
                {
                    $this->contact->setEmail($this->getRequestParameter('group_email'));
                    $this->contact->save();
                }

                $this->work_address->setCountry($this->getRequestParameter('group_country'));
                $this->work_address->setStreet($this->getRequestParameter('group_street'));
                $this->work_address->setCity($this->getRequestParameter('group_city'));
                $this->work_address->setPostalCode($this->getRequestParameter('group_postalcode'));
                $this->work_address->setState($this->getRequestParameter('group_state'));
                $this->work_address->setContactId($this->contact->getId());
                $this->work_address->setType(ContactPeer::WORK);
                $this->work_address->save();

                $this->work_phone->setPhone($this->getRequestParameter('group_phone'));
                $this->work_phone->setType(ContactPeer::WORK);
                $this->work_phone->setContactId($this->contact->getId());
                $this->work_phone->save();

                $this->fax_number->setPhone($this->getRequestParameter('group_fax'));
                $this->fax_number->setType(ContactPeer::FAX);
                $this->fax_number->setContactId($this->contact->getId());
                $this->fax_number->save();
                
                ActionLogPeer::Log($this->group, ActionPeer::ACT_UPDATE_CONTACT_INFO);
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Group information has been saved successfully.', null, null, true);
                $this->redirect("@edit-group-profile?hash={$this->group->getHash()}");
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing group information. Please try again later.', null, null, false);
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