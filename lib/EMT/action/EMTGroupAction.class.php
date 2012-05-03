<?php

class EmtGroupAction extends EmtAction
{
    protected $actionID = null;
    
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
        
        if ($this->getRequestParameter('stripped_name'))
        {
            $this->group = GroupPeer::retrieveByStrippedName($this->getRequestParameter('stripped_name'));
        }
        elseif ($this->getContext()->getConfiguration()->getApplication() !== 'cm' && $this->getRequestParameter('hash'))
        {
            $this->group = GroupPeer::getGroupFromHash($this->getRequestParameter('hash'));
        }
        if (!$this->group || $this->group->getOwner()->isBlocked()) $this->redirect404();

        if (!$this->sesuser->isNew())
            $this->isMember = $this->group->hasMembership($this->sesuser->getId(), PrivacyNodeTypePeer::PR_NTYP_USER);
        else
            $this->isMember = false;
        
        $this->own_group = $this->sesuser->isOwnerOf($this->group);

        $this->goodToRun = $this->actionID ? $this->sesuser->can($this->actionID, $this->group) : null;

        $this->nums = array();
        $this->nums['discussions'] = $this->group->getActiveDiscussions(null, true);
        $this->nums['connections'] = $this->group->getConnections(null, array(RolePeer::RL_GP_LINKED_GROUP, RolePeer::RL_MEMBERED_GROUP), true, false, null, false, 0, null, array(), null, true);
        $this->nums['events'] = $this->group->countEventsByPeriod(EventPeer::EVN_PRTYP_FUTURE);
        $this->nums['jobs'] = $this->group->countOnlineJobs();
        $this->nums['photos'] = $this->group->getPhotos(null, true);
    }
    
    public function execute($request)
    {
    }
    
}

