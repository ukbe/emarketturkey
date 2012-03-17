<?php

class selectRegionAction extends EmtAction
{
    public function execute($request)
    {
        if (!$this->getRequest()->isXmlHttpRequest())
        {
            $this->renderText('NOT ALLOWED');
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->cc = substr($this->getRequestParameter('country_id', '##'), 0, 2);
            $this->getResponse()->setCookie('EMT_HR_REGION', $this->cc, time()+60*60*24*15);
            $this->cities = GeonameCityPeer::getCitiesFor($this->cc);
        }
    }
}