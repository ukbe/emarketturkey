<?php

class contactAction extends EmtCVAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
        
        $this->profile_contact = ($this->sesuser->getUserProfile()? $this->sesuser->getUserProfile()->getContact():null); 
        
        if (!$this->resume->isNew() && $this->getRequestParameter('mod')=='rfp')
        {
            $this->contact = $this->profile_contact;
        }
        else
        {
            if (!$this->resume->getContact())
                $this->resume->setContact(new Contact());
                
            $this->contact = $this->resume->getContact();
        }
        
        $this->home_address = $this->contact->getHomeAddress();
        $this->home_phone = $this->contact->getHomePhone();
        $this->work_address = $this->contact->getWorkAddress();
        $this->work_phone = $this->contact->getWorkPhone();

        
        if (!$this->home_address)
            $this->home_address = new ContactAddress();
        if (!$this->home_phone)
            $this->home_phone = new ContactPhone();
        if (!$this->work_address)
            $this->work_address = new ContactAddress();
        if (!$this->work_phone)
            $this->work_phone = new ContactPhone();
        
        if ($this->home_address && $this->home_address->getCountry()!='')
            $this->contact_cities = GeonameCityPeer::getCitiesFor($this->home_address->getCountry());
        elseif ($this->work_address && $this->work_address->getCountry()!='')
            $this->contact_cities = GeonameCityPeer::getCitiesFor($this->work_address->getCountry());
        else
            $this->contact_cities = array();
        
        //  prepare email list
        $this->user_emails = array($this->sesuser->getLogin()->getEmail() => $this->sesuser->getLogin()->getEmail());
        if ($this->sesuser->getAlternativeEmail() != '') $this->user_emails[$this->sesuser->getAlternativeEmail()] = $this->sesuser->getAlternativeEmail();
        $this->user_emails['x'] = $this->getContext()->getI18N()->__('Do not include');
        $this->user_emails['new'] = $this->getContext()->getI18N()->__('Use a new one');

        $this->other_email = (array_key_exists($this->contact->getEmail(), $this->user_emails)?false:true);
    }
    
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
                    $this->contact->setEmail($this->getRequestParameter('rsmc_email') == 'x' ? '' : ($this->getRequestParameter('rsmc_email') == 'new' ? $this->getRequestParameter('rsmc_otheremail') : $this->getRequestParameter('rsmc_email')));
                    $this->contact->save();
                    $this->contact->reload();

                    $this->home_phone->setContactId($this->contact->getId());
                    $this->home_phone->setType(ContactPeer::HOME);
                    $this->home_phone->setPhone($this->getRequestParameter('rsmc_home_phone'));
                    $this->home_phone->save();
                    
                    $this->home_address->setContactId($this->contact->getId());
                    $this->home_address->setType(ContactPeer::HOME);
                    $this->home_address->setCountry($this->getRequestParameter('rsmc_home_country'));
                    $this->home_address->setStreet($this->getRequestParameter('rsmc_home_street'));
                    $this->home_address->setCity($this->getRequestParameter('rsmc_home_city'));
                    $this->home_address->setPostalcode($this->getRequestParameter('rsmc_home_postalcode'));
                    $this->home_address->setState($this->getRequestParameter('rsmc_home_state'));
                    $this->home_address->save();
                    
                    $this->work_phone->setContactId($this->contact->getId());
                    $this->work_phone->setType(ContactPeer::WORK);
                    $this->work_phone->setPhone($this->getRequestParameter('rsmc_work_phone'));
                    $this->work_phone->save();
                    
                    $this->work_address->setContactId($this->contact->getId());
                    $this->work_address->setType(ContactPeer::WORK);
                    $this->work_address->setCountry($this->getRequestParameter('rsmc_work_country'));
                    $this->work_address->setStreet($this->getRequestParameter('rsmc_work_street'));
                    $this->work_address->setCity($this->getRequestParameter('rsmc_work_city'));
                    $this->work_address->setPostalcode($this->getRequestParameter('rsmc_work_postalcode'));
                    $this->work_address->setState($this->getRequestParameter('rsmc_work_state'));
                    $this->work_address->save();
                    
                    $this->resume->setContactId($this->contact->getId());
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
                    $this->redirect('@mycv-action?action=education');
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
