<?php

class setupProfileAction extends EmtAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->profile = $this->sesuser->getUserProfile();
        if (!$this->profile) $this->profile = new UserProfile();
        $this->contact = $this->profile->getContact();
        if (!$this->contact) $this->contact = new Contact();
        $this->address = $this->contact->getAddressByType($this->getRequestParameter('contact_type', ContactPeer::WORK));
        if (!$this->address) $this->address = new ContactAddress();
        $this->phone = $this->contact->getPhoneByType($this->getRequestParameter('contact_type', ContactPeer::WORK));
        if (!$this->phone) $this->phone = new ContactPhone();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
            $this->home_cnt = $this->getRequestParameter('profile_hometown_country');
        else
            $this->home_cnt = $this->profile->getHomeCountry();
            
        if ($this->home_cnt)
            $this->local_cities = GeonameCityPeer::getCitiesFor($this->home_cnt);
        else
            $this->local_cities = array();
            
        if ($this->getRequest()->getMethod() == sfRequest::POST)
            $this->cont_cnt = $this->getRequestParameter('contact_country');
        else
            $this->cont_cnt = $this->address->getCountry();
            
        if ($this->cont_cnt)
            $this->contact_cities = ($this->home_cnt === $this->cont_cnt ? $this->local_cities : GeonameCityPeer::getCitiesFor($this->cont_cnt));
        else
            $this->contact_cities = array();
    }
    
    public function execute($request)
    {
        return $this->handleAction(false);
    }
    
    public function handleAction($isValidationError)
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            if ($this->contact->isNew())
            {
                $this->contact->setEmail($this->sesuser->getLogin()->getEmail());
                $this->contact->save();
            }
            $this->profile->setHomeCountry($this->getRequestParameter('profile_hometown_country'));
            $this->profile->setHomeTownId($this->getRequestParameter('profile_hometown_state'));
            $this->profile->setPreferredLanguage($this->getRequestParameter('profile_preferred_lang'));
            $this->profile->setMaritalStatus($this->getRequestParameter('profile_marital_status'));
            $this->profile->setContactId($this->contact->getId());
            $this->profile->save();
            
            $this->address->setContactId($this->contact->getId());
            $this->address->setCountry($this->getRequestParameter('contact_country'));
            $this->address->setStreet($this->getRequestParameter('contact_street'));
            $this->address->setCity($this->getRequestParameter('contact_town'));
            $this->address->setPostalcode($this->getRequestParameter('contact_postal_code'));
            $this->address->setType($this->getRequestParameter('contact_type'));
            $this->address->setState($this->getRequestParameter('contact_state'));
            $this->address->save();
            $this->phone->setContactId($this->contact->getId());
            $this->phone->setPhone($this->getRequestParameter('contact_phone'));
            $this->phone->setType($this->getRequestParameter('contact_type'));
            $this->phone->save();
            if ($this->getRequestParameter('newi') == 1)
            {
                $photo = $this->sesuser->getProfilePicture();
                if ($photo)
                {
                    $offx = $this->getRequestParameter('offx');
                    $photo->setOffsetPad($offx !== 0 ? $offx : $this->getRequestParameter('offy'));
                    $photo->save();
                    $photo->sampleFiles();
                }
            }
            $this->redirect('@cm.friendfinder?sup=true');
        }

    }
    
    public function validate()
    {
        if (count($this->local_cities)== 0) $this->getRequest()->removeError('profile_hometown_state');
        if (count($this->contact_cities)== 0) $this->getRequest()->removeError('contact_state');
        
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}