<?php

class Poll extends BasePoll
{
    public function getOptions()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(PollItemPeer::SEQUENCE_ID);
        return $this->getPollItems($c);
    }
    
    public function getOptionGuids()
    {
        $c = new Criteria();
        $c->addSelectColumn(PollItemPeer::GUID);
        $c->addAscendingOrderByColumn(PollItemPeer::SEQUENCE_ID);
        $c->addJoin(PollItemPeer::POLL_ID, PollPeer::ID, Criteria::LEFT_JOIN);
        $c->add(PollPeer::ID, $this->getId());
        $stmt = BasePeer::doSelect($c);
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
    
    public function getOptionBySequenceId($seq)
    {
        $c = new Criteria();
        $c->add(PollItemPeer::SEQUENCE_ID, $seq);
        $opt = $this->getPollItems($c);
        return count($opt) ? $opt[0] : null;
    }
    
    public function getOptionByGuid($guid)
    {
        $c = new Criteria();
        $c->add(PollItemPeer::GUID, $guid);
        $opt = $this->getPollItems($c);
        return count($opt) ? $opt[0] : null;
    }
    
    public function getVisitorsVote()
    {
        $cook = PollPeer::prepareCookie();
        
        $request = sfContext::getInstance()->getRequest();
        
        // Check cookie for selected item
        if (!is_array($p))
        {
            $p = array();
            $this->getResponse()->setCookie('POLL', base64_encode(serialize($p)));
        }
        
        $selection = array_key_exists($this->getGuid(), $p) ? $this->getOptionByGuid($p[$this->getGuid()])->getSequenceId() : null;
        if (!($selection > 0 and $selection < $this->countPollItems()))
        {
            $selection = 1;
        }
        return $selection;
    }
    
    public function getOwner()
    {
        return null;
    }
    
}
