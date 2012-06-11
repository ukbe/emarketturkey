<?php

class viewAction extends EmtEventAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle($this->event . ' | eMarketTurkey');

        $this->photos = $this->event->getPhotos();
        $this->user_photos = array();
        $this->i18ns = $this->event->getExistingI18ns();
        $this->place = $this->event->getPlace();
        $this->organiser = $this->event->getOrganiser();
        $this->time_scheme = $this->event->getTimeScheme() ? $this->event->getTimeScheme() : new TimeScheme();
        $this->attenders = $this->event->getAttenders(null, false, EventPeer::EVN_ATTYP_ATTENDING);
        $this->att_count = 0;
        foreach ($this->attenders as $list)
        {
            $this->att_count += count($list);
        }
                
        RatingPeer::logNewVisit($this->event->getId(), PrivacyNodeTypePeer::PR_NTYP_EVENT);
    }
    
    public function handleError()
    {
    }
    
}