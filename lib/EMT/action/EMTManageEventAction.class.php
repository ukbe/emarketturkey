<?php

class EmtManageEventAction extends EmtManageAction
{
    protected $enforceEvent = true;
    
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->otyp = (int)$this->getRequestParameter('otyp');

        switch ($this->otyp)
        {
            case PrivacyNodeTypePeer::PR_NTYP_COMPANY :
                $this->owner = CompanyPeer::getCompanyFromUrl($this->getRequest()->getParameterHolder());
                break;
            case PrivacyNodeTypePeer::PR_NTYP_GROUP :
                $this->owner = GroupPeer::getGroupFromUrl($this->getRequest()->getParameterHolder());
                break;
            default:
                $this->redirect404();
        }
        
        if (!$this->owner) $this->redirect404();

        $this->own = $this->owner->getHash();
        
        if (!$this->sesuser->isNew() && !$this->sesuser->isOwnerOf($this->owner)) $this->redirect404();
        
        $this->event = EventPeer::getEventFromUrl($this->getRequest()->getParameterHolder());
        if ($this->enforceEvent && !$this->event) $this->redirect404();
        
        $this->route = ($this->otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "@company-events-action?hash={$this->own}" : "@group-events-action?hash={$this->own}");
        $this->eventroute = $this->event ? ($this->otyp == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "@company-event-action?hash={$this->own}&id={$this->event->getId()}" : "@group-events-action?hash={$this->own}&id={$this->event->getId()}") : null;
    }
    
}
