<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect("@camp.tradeshows", 301);

        $this->featured_shows = EventPeer::getFeaturedEvents(5, EventTypePeer::ECLS_TYP_BUSINESS);
        $this->net_attenders = array();
    }
    
    public function handleError()
    {
    }
    
}
