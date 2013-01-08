<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect("@camp.venues", 301);

        $this->featured_venues = PlacePeer::getFeaturedPlaces(5, PlaceTypePeer::$bussTypes);
    }
    
    public function handleError()
    {
    }
    
}
