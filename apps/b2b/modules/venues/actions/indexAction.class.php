<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        $this->featured_venues = PlacePeer::getFeaturedPlaces(5, PlaceTypePeer::$bussTypes);
    }
    
    public function handleError()
    {
    }
    
}
