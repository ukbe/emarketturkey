<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class requestsAction extends EmtAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->friend_requests = $this->sesuser->getFriendshipRequests();
        $this->group_invitations = $this->sesuser->getGroupInvitations();
        $this->relation_updates = $this->sesuser->getRelationUpdateRequests();
        $this->group_requests = $this->sesuser->getGroupRequests();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                
            }
        }
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