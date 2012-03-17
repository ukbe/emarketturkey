<?php

class membersAction extends EmtGroupAction
{
    protected $actionID = ActionPeer::ACT_MANAGE_MEMBERS;
    
    public function execute($request)
    {
        if (!$this->goodToRun) $this->redirect404();
        
        $this->tips = array();
        
        if ($this->getRequestParameter('typ') == 'pending')
        {
            $this->people = $this->group->getPendingPeople();
            $this->companies = $this->group->getPendingCompanies();
            $this->groups = $this->group->getPendingGroups();
            $this->setTemplate('pendingMembers');
            return sfView::SUCCESS;
        }

        $this->people = $this->group->getActivePeople();
        $this->companies = $this->group->getActiveCompanies();
        $this->groups = $this->group->getActiveGroups();
        
        if (!$this->group->getLogo()) $this->tips['Upload Group Logo'] = array('group/logo?id='.$this->group->getId(), 'Group does not have a logo.');
        if ($this->group->countMembers() < 2) $this->tips['Invite People to Group'] = array('group/invite?id='.$this->group->getId(), 'Group does not have any members.');
    }
    
    public function handleError()
    {
    }
    
}
