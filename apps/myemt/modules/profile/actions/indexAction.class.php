<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class indexAction extends EmtAction
{
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->getRequestParameter('id'))
        {
            $this->user = UserPeer::retrieveByPK($this->getRequestParameter('id'));
        }
        elseif ($this->getRequestParameter('username'))
        {
            $this->user = UserPeer::retrieveByUsername($this->getRequestParameter('username'));
        }
        else
        {
            $this->user = $this->getUser()->getUser();
        }
        
        $this->friends = $this->user->getFriends(null, true);
        
        if (!$this->user || 
            ($this->user->getId() != $this->getUser()->getUser()->getId() &&
             !$this->getUser()->getUser()->can(ActionPeer::ACT_VIEW_PROFILE, $this->user)))
        { 
            $this->redirect('@homepage');
        }
        
        $this->profile = $this->user->getUserProfile();
        if (!$this->profile)
        {
            $this->profile = new UserProfile();
            $this->user->setUserProfile($this->profile);
        }
        
        $this->contact = $this->profile->getContact();
        if (!$this->contact) $this->contact = new Contact();
        if (!$this->contact->getHomePhone()) $this->home_phone = new ContactPhone(); else $this->home_phone = $this->contact->getHomePhone();
        if (!$this->contact->getWorkPhone()) $this->work_phone = new ContactPhone(); else $this->work_phone = $this->contact->getWorkPhone();
        if (!$this->contact->getHomeAddress()) $this->home_address = new ContactAddress(); else $this->home_address = $this->contact->getHomeAddress();
        if (!$this->contact->getWorkAddress()) $this->work_address = new ContactAddress(); else $this->work_address = $this->contact->getWorkAddress();
        
        $this->occupations = $this->user->getWorkHistory(false);
        
        if ($this->user->getId() != $this->getUser()->getUser()->getId())
            $this->setTemplate('otherUserProfile');

        $this->getResponse()->setTitle($this->user);
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