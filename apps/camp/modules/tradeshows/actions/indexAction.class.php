<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $this->featured_shows = EventPeer::getFeaturedEvents(5, EventTypePeer::ECLS_TYP_BUSINESS);
        $this->net_attenders = array();
    }
    
    public function handleError()
    {
    }
    
}
