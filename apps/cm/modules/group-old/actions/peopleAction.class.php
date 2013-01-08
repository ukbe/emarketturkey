<?php

class peopleAction extends EmtGroupAction
{
    protected $actionID = ActionPeer::ACT_VIEW_PEOPLE;
    
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect("@camp.group-profile-action?action=connections&stripped_name={$this->group->getStrippedName()}&relation=people", 301);

        $this->pvars = array();
        $this->setTemplate('profileScheme');
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->companies = $this->group->getActiveCompanies();
        $this->people = $this->group->getActivePeople();
        
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
        
        $this->getResponse()->setTitle($this->group->getDisplayName() . ' | eMarketTurkey');
        
        // Define viewable tabs
        $this->tabs = $this->group->getProfileTabsForUser($this->sesuser);
        
        $this->tabindex = 'people';
        
        // Attach variables to be used in the partial and template
        $this->pvars['group'] = $this->group;
        $this->pvars['people'] = $this->people;
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