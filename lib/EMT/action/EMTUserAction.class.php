<?php

class EmtUserAction extends EmtAction
{
    protected $actionID = null;

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->user = UserPeer::getUserFromUrl($this->getRequest()->getParameterHolder());

        if (!$this->user || $this->user->isBlocked()) $this->redirect404();

        $this->goodToRun = $this->actionID ? $this->sesuser->can($this->actionID, $this->user) : null;

        $this->profile = $this->user->getUserProfile();

        $this->thisIsMe = ($this->user->getId() == $this->sesuser->getId());

        $this->nums = array();
        $this->nums['crworks'] = $this->user->getResume() ? $this->user->getResume()->countResumeWorks() : 0;
        $this->nums['crschools'] = $this->user->getResume() ? $this->user->getResume()->countResumeSchools() : 0;
        $this->nums['events'] = $this->user->countEventsByPeriod(EventPeer::EVN_PRTYP_FUTURE);
        $this->nums['connections'] = $this->user->getConnections(null, array(RolePeer::RL_NETWORK_MEMBER), true, false, null, false, 0, null, array(), null, true);
        $this->nums['photos'] = $this->user->getPhotos(null, true);
    }

    public function execute($request)
    {
    }
    
}

