<?php

class updateLocationAction extends EmtUserAction
{
    
    public function execute($request)
    {
        $user = $this->sesuser;
        
        if ($this->hasRequestParameter('city_id'))
        {
            $user->setLocationUpdate($this->getRequestParameter('city_id'));
        }
        $l = $user->getLocationUpdate();
        $str = implode(',', array_filter(array($l->getGeonameCityRelatedByCity(), $l->getGeonameCityRelatedByState()?$l->getGeonameCityRelatedByState()->getAdmin1Code():null))) . '<img class="flag" src="/images/layout/flag/'.$l->getCountry().'.png" alt="'.$this->getContext()->getI18N()->getCountry($l->getCountry()).'" />';
        return $this->renderText($str);
    }
    
    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}