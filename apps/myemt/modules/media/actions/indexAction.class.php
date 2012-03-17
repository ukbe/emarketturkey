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
        else
        {
            $this->user = $this->getUser()->getUser();
        }
        if (!$this->user || 
            ($this->user->getId() != $this->getUser()->getUser()->getId() &&
             !$this->getUser()->getUser()->can(ActionPeer::ACT_VIEW_FRIENDS, $this->user)))
        { 
            $this->redirect('@homepage');
        }
        
        
        $this->req_count = $this->user->getRequestCount();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                
            }
        }
        else
        {
            //$this->friends = $this->user->getFriends();
            
        }

        if ($this->user->getId() != $this->getUser()->getUser()->getId())
        {
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("%1's Photo Albums | eMarketTurkey", array('%1' => $this->user)));
            
            $this->setTemplate('otherUserMedia');
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