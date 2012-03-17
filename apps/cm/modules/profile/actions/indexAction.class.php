<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class indexAction extends EmtUserAction
{
    
    public function execute($request)
    {
        $this->pvars = array();
        $this->setTemplate('profileScheme');
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->friends = $this->user->getFriends(null, true);
        $this->groups = $this->user->getGroups();
        
        if ($this->user->getId() != $this->sesuser->getId() &&
            !$this->sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $this->user))
        {
            if ($this->sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $this->user))
            {
                //$this->setTemplate('publicUserProfile');
            }
            else
            {
                $this->setTemplate('lockedProfile');
            }
        }
        if (!($viewinfo = $this->sesuser->can(ActionPeer::ACT_VIEW_PERSONAL_INFO, $this->user)))
        {
            $this->setTemplate('protectedContent');
            return sfView::SUCCESS;
        }
        
        $profile = $this->user->getUserProfile();
        if (!$profile)
        {
            $profile = new UserProfile();
            $this->user->setUserProfile($profile);
        }
        
        $contact = $profile->getContact();
        if (!$contact) $contact = new Contact();
        if (!$contact->getHomePhone()) $home_phone = new ContactPhone(); else $home_phone = $contact->getHomePhone();
        if (!$contact->getWorkPhone()) $work_phone = new ContactPhone(); else $work_phone = $contact->getWorkPhone();
        if (!$contact->getHomeAddress()) $home_address = new ContactAddress(); else $home_address = $contact->getHomeAddress();
        if (!$contact->getWorkAddress()) $work_address = new ContactAddress(); else $work_address = $contact->getWorkAddress();
        
        $this->getResponse()->setTitle($this->user . ' | eMarketTurkey');
        
        $this->token = sha1(base64_encode($this->user.session_id()));
        
        // Define viewable tabs
        
        $this->tabs = $this->user->getProfileTabsForUser($this->sesuser);
        
        $this->tabindex = 'info';
        
        // Attach variables to be used in the partial and template
        $this->pvars['viewinfo'] = $viewinfo;
        $this->pvars['profile'] = $profile;
        $this->pvars['user'] = $this->user;
        $this->pvars['contact'] = $contact;
        $this->pvars['home_phone'] = $home_phone;
        $this->pvars['work_phone'] = $work_phone;
        $this->pvars['home_address'] = $home_address;
        $this->pvars['work_address'] = $work_address;
        $this->pvars['sesuser'] = $this->sesuser;
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