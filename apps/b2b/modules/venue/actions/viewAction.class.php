<?php

class viewAction extends EmtPlaceAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle($this->place . ' | eMarketTurkey');

        $this->owner = $this->place->getOwner();
        $this->contact = $this->place->getContact();
        $this->address = $this->contact ? $this->contact->getWorkAddress() : null;

        $this->future_events = $this->place->getEventsByPeriod(EventPeer::EVN_PRTYP_FUTURE);
        $this->past_events = $this->place->getEventsByPeriod(EventPeer::EVN_PRTYP_PAST);

        RatingPeer::logNewVisit($this->place->getId(), PrivacyNodeTypePeer::PR_NTYP_PLACE);
    }
    
    public function handleError()
    {
    }
    
}