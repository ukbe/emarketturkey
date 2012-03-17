<?php

class setrecipientAction extends EmtAction
{
    public function execute($request)
    {
        /*if (!$this->getRequest()->isXmlHttpRequest() || $this->getRequestParameter('user', -1) != $this->getUser()->getUser()->getId())
        {
            $this->redirect404();
        }
        $this->userid = $this->getRequestParameter('user', 0);
        */

        //if ($this->getRequest()->getMethod() == sfRequest::POST)
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
                return false;
            }
            
            $this->keyword = $this->getRequestParameter('type_rcpnt', '#EMPTYNOTALLOWED#');
            $this->friends = $this->user->getFriends($this->keyword);
        }
    }
}