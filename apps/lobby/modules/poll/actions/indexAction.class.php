<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        
        $poll = PollPeer::retrieveByGuid($this->getRequestParameter('poll'));
        if (!$poll)
        {
            $this->redirect404();
        }

        $referer = $_SERVER['HTTP_REFERER'];
        if (!preg_match('/'.str_replace('/', "\/", $poll->getRefererMask()).'/', $referer))
        {
            $this->redirect404();
        }

        $selection = $poll->getOptionByGuid($this->getRequestParameter('selection'));
        if (!$poll)
        {
            $this->redirect404();
        }
        
        $client_user = ClientUserPeer::retrieveUser();
        $p =$client_user->setPollVote($poll->getGuid(), $selection->getGuid(), $this->sesuser->getId());

        $this->redirect(($rt=$poll->getReturnTo()) ? str_replace('#sf_culture#', $this->getUser()->getCulture(), $rt) : $this->getRequest()->getReferer());
    }
    
    public function handleError()
    {
    }
    
}
