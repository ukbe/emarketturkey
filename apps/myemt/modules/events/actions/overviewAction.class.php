<?php

class overviewAction extends EmtManageEventAction
{
    protected $enforceEvent = false;

    public function execute($request)
    {
        $this->events_today = $this->owner->getEventsByPeriod(EventPeer::EVN_PRTYP_TODAY);
        $this->events_this_week = $this->owner->getEventsByPeriod(EventPeer::EVN_PRTYP_THIS_WEEK);
        $this->events_next_week = $this->owner->getEventsByPeriod(EventPeer::EVN_PRTYP_NEXT_WEEK);
    }
    
    public function handleError()
    {
    }
    
}
