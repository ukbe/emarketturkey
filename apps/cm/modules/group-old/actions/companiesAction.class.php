<?php

class companiesAction extends EmtGroupAction
{
    protected $actionID = ActionPeer::ACT_VIEW_COMPANIES;
    
    public function execute($request)
    {
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
        
        $this->tabindex = 'companies';
        
        // Attach variables to be used in the partial and template
        $this->pvars['group'] = $this->group;
        $this->pvars['companies'] = $this->companies;
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