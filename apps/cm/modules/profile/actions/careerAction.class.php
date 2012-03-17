<?php

class careerAction extends EmtUserAction
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
                $this->setTemplate('publicUserProfile');
            }
            else
            {
                $this->setTemplate('lockedProfile');
            }
        }
        if (!($viewinfo = $this->sesuser->can(ActionPeer::ACT_VIEW_CAREER, $this->user)))
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
        
        $occupations = $this->user->getWorkHistory(false);
        $educations = $this->user->getEducationHistory(false);
                
        $this->getResponse()->setTitle($this->user . ' | eMarketTurkey');
        
        $this->token = sha1(base64_encode($this->user.session_id()));
        
        // Define viewable tabs
        
        $this->tabs = $this->user->getProfileTabsForUser($this->sesuser);
        
        $tab = strtolower($this->getRequestParameter('action'));
        $this->tabindex = 'career';
        
        // Attach variables to be used in the partial and template
        $this->pvars['viewinfo'] = $viewinfo;
        $this->pvars['profile'] = $profile;
        $this->pvars['user'] = $this->user;
        $this->pvars['sesuser'] = $this->sesuser;
        $this->pvars['occupations'] = $occupations;
        $this->pvars['educations'] = $educations;
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