<?php

class ClientUser extends BaseClientUser
{
    public function getPollVote($pollguid)
    {
        $c = new Criteria();
        $c->addJoin(PollVotePeer::ITEM_ID, PollItemPeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(PollItemPeer::POLL_ID, PollPeer::ID, Criteria::LEFT_JOIN);
        $c->add(PollPeer::GUID, $pollguid);
        $votes = $this->getPollVotes($c);
        return count($votes) ? $votes[0] : null;
    }
    
    public function setPollVote($pollguid, $optionguid)
    {
        $poll = PollPeer::retrieveByGuid($pollguid);
        if (!$poll || $poll->getStatus()!==PollPeer::PL_STAT_ACTIVE)
        {
            return false;
        }
        $option = $poll->getOptionByGuid($optionguid);

        if (!$option) return false;
        
        $existingvote = $this->getPollVote($pollguid);
        if (!$existingvote)
        {
            $existingvote = new PollVote();
            $existingvote->setClientUserId($this->getId());
        }
        $existingvote->setItemId($option->getId());
        $existingvote->save();
        return true;
    }
}
