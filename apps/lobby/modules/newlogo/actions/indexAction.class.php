<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $this->poll = PollPeer::retrieveByGuid('8C2EF53F9F594CD6AEF215CB80E14DF6');

        $client_user = ClientUserPeer::retrieveUser();
        if (!$client_user)
        {
            $client_device = new ClientDevice();
            $client_device->setIp(ip2long($_SERVER['REMOTE_ADDR']));
            $client_device->save();
            $client_user = $client_device->addUser(null);
        }
        $this->vote = $client_user->getPollVote($this->poll->getGuid());
        $this->options = $this->poll->getOptions();

        if ($this->vote)
        {
            $this->selection = $this->vote->getPollItem()->getSequenceId();
            if ($this->getRequestParameter('done') == 'ok')
            {
                $this->setTemplate('thankyouMessage');
                return sfView::SUCCESS;
            }
        }
        else
        {
            $this->selection = 1;
        }
    }
    
    public function handleError()
    {
    }
    
}
