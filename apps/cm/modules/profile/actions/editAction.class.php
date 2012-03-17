<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class editAction extends EmtUserAction
{
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->profile = $this->user->getUserProfile();
        if (!$this->profile) $this->profile = new UserProfile();
        $this->contact = $this->profile->getContact();
        if (!$this->contact) $this->contact = new Contact();
        if (!$this->contact->getHomePhone()) $this->home_phone = new ContactPhone(); else $this->home_phone = $this->contact->getHomePhone();
        if (!$this->contact->getWorkPhone()) $this->work_phone = new ContactPhone(); else $this->work_phone = $this->contact->getWorkPhone();
        if (!$this->contact->getHomeAddress()) $this->home_address = new ContactAddress(); else $this->home_address = $this->contact->getHomeAddress();
        if (!$this->contact->getWorkAddress()) $this->work_address = new ContactAddress(); else $this->work_address = $this->contact->getWorkAddress();
            
        $gender =  array('male' => 1,
                         'female' => 2,
                         '' => 0
                         );
        $updtcntct = false;
                         
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                if (!$this->profile) $this->profile = new UserProfile();
                
                if ($this->contact->isNew())
                {
                    $this->contact->save();
                }
                
                $this->home_phone->setPhone($this->getRequestParameter('profile_home_phone'));
                if ($this->home_phone->isModified())
                {
                    $this->home_phone->setContactId($this->contact->getId());
                    $this->home_phone->setType(ContactPeer::HOME);
                    $this->home_phone->save();
                    $updtcntct = true;
                }
                
                $this->home_address->setCountry($this->getRequestParameter('profile_contact_country'));
                $this->home_address->setStreet($this->getRequestParameter('profile_home_street'));
                $this->home_address->setCity($this->getRequestParameter('profile_home_city'));
                $this->home_address->setState($this->getRequestParameter('profile_home_state'));
                $this->home_address->setPostalCode($this->getRequestParameter('profile_home_postalcode'));
                if ($this->home_address->isModified())
                {
                    $this->home_address->setContactId($this->contact->getId());
                    $this->home_address->setType(ContactPeer::HOME);
                    $this->home_address->save();
                    $updtcntct = true;
                }
                
                $this->work_phone->setPhone($this->getRequestParameter('profile_work_phone'));
                if ($this->work_phone->isModified())
                {
                    $this->work_phone->setContactId($this->contact->getId());
                    $this->work_phone->setType(ContactPeer::WORK);
                    $this->work_phone->save();
                    $updtcntct = true;
                }
                
                $this->work_address->setCountry($this->getRequestParameter('profile_contact_country'));
                $this->work_address->setStreet($this->getRequestParameter('profile_work_street'));
                $this->work_address->setCity($this->getRequestParameter('profile_work_city'));
                $this->work_address->setState($this->getRequestParameter('profile_work_state'));
                $this->work_address->setPostalCode($this->getRequestParameter('profile_work_postalcode'));
                if ($this->work_address->isModified())
                {
                    $this->work_address->setContactId($this->contact->getId());
                    $this->work_address->setType(ContactPeer::WORK);
                    $this->work_address->save();
                    $updtcntct = true;
                }
                
                $this->profile->setMaritalStatus($this->getRequestParameter('profile_marital_stat'));
                $this->profile->setPreferredLanguage($this->getRequestParameter('profile_preferred_lang'));
                $this->profile->setHomeTownId($this->getRequestParameter('profile_hometown_state'));
                $this->profile->setHomeCountry($this->getRequestParameter('profile_hometown_country'));
                $this->profile->setContactId($this->contact->getId());
                $this->profile->save();
                $this->user->setProfileId($this->profile->getId());
                $this->user->setGender($gender[$this->getRequestParameter('profile_gender')]);
                $this->user->setBirthdate($this->getRequestParameter('profile_bd_year').'-'.
                    $this->getRequestParameter('profile_bd_month').'-'.
                    $this->getRequestParameter('profile_bd_day'));
                $this->user->save();
                
                ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_UPDATE_CONTACT_INFO);
                if ($this->getRequestParameter('redir')!='') 
                    $this->redirect($this->getRequestParameter('redir'));
                else
                    $this->redirect($this->user->getProfileUrl());
            }
        }
        
        if ($this->profile->getHomeCountry())
            $this->local_cities = GeonameCityPeer::getCitiesFor($this->profile->getHomeCountry());
        else
            $this->local_cities = array();
        if ($this->home_address->getCountry())
            $this->contact_cities = ($this->profile->getHomeCountry() === $this->home_address->getCountry() ? $this->local_cities : GeonameCityPeer::getCitiesFor($this->home_address->getCountry()));
        else
            $this->contact_cities = array();
        
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