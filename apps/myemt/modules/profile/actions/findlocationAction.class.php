<?php

class findlocationAction extends EmtAction
{
    public function execute($request)
    {
        if (!$this->getRequest()->isXmlHttpRequest())
        {
            $this->renderText(__('NOT ALLOWED'));
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->cc = substr($this->getRequestParameter('country_code', '##'), 0, 2);
            $this->cities = GeonameCityPeer::getCitiesFor($this->cc);
        }
    }
}