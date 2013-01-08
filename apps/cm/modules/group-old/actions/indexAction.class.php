<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class indexAction extends EmtGroupAction
{
    
    protected $actionID = ActionPeer::ACT_VIEW_PROFILE;
    
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect("@camp.group-profile?stripped_name={$this->group->getStrippedName()}", 301);

        $this->pvars = array();
        $this->setTemplate('profileScheme');
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->people = $this->group->getActivePeople();
        $this->companies = $this->group->getActiveCompanies();
        
        if (!$this->sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $this->group))
        {
            if ($this->sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $this->group))
            {
                $this->setTemplate('publicGroupProfile');
            }
            else
            {
                $this->setTemplate('lockedProfile');
            }
        }
        if (!$this->goodToRun)
        {
            $this->setTemplate('protectedContent');
            return sfView::SUCCESS;
        }
        
        $contact = $this->group->getContact();
        if (!$contact) $contact = new Contact();
        if (!$contact->getWorkPhone()) $work_phone = new ContactPhone(); else $work_phone = $contact->getWorkPhone();
        if (!$contact->getWorkAddress()) $work_address = new ContactAddress(); else $work_address = $contact->getWorkAddress();
        
        $this->getResponse()->setTitle($this->group->getDisplayName() . ' | eMarketTurkey');
        
        // Define viewable tabs
        $this->tabs = $this->group->getProfileTabsForUser($this->sesuser);
        
        $this->tabindex = 'info';
        
        // Attach variables to be used in the partial and template
        $this->pvars['group'] = $this->group;
        $this->pvars['contact'] = $contact;
        $this->pvars['work_phone'] = $work_phone;
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