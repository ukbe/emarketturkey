<?php

class indexAction extends EmtAction
{
    public function execute($request)
    {
        if (!$this->getUser()->getAttribute('culture_selected') && $_SERVER["REQUEST_URI"]="/")
        {
            foreach ($this->getRequest()->getLanguages() as $lang)
            {
                if (array_search($lang, array('tr', 'en')) !== false)
                {
                    $this->getUser()->setAttribute('culture_selected', true);
                    $this->redirect(myTools::localizedUrl($lang));
                }
            }
        }
        
        $cookieparams = session_get_cookie_params();
        $cook = base64_encode('hr');
        $this->getResponse()->setCookie('EMT_STARTUP', $cook, time()+60*60*24*15, '/', $cookieparams['domain']);

        if ($this->sesuser && $this->sesuser->getUserProfile()) $this->sesuser_country = $this->sesuser->getUserProfile()->getSelectedHRRegion();
        else $this->sesuser_country = $this->getRequest()->getCookie('EMT_HR_REGION');

        if (!$this->sesuser_country && $this->sesuser && $this->sesuser->getUserProfile() && ($co = $this->sesuser->getUserProfile()->getContact()))
        {
            if (($ha = $co->getHomeAddress()))
            {
                $this->sesuser_country = $ha->getCountry();
                $this->sesuser_state = $ha->getState();
            }
            elseif (($wa = $co->getWorkAddress()))
            {
                $this->sesuser_country = $wa->getCountry();
                $this->sesuser_state = $wa->getState();
            }
            $this->sesuser->getUserProfile()->setSelectedHRRegion($this->sesuser_country);
            $this->sesuser->getUserProfile()->save();
        }

        $this->sesuser_states = GeonameCityPeer::getCitiesFor($this->sesuser_country);

        $c = new Criteria();
        $c->addAscendingOrderByColumn(BusinessSectorI18nPeer::NAME);

        if (!$this->sesuser->isNew()) 
        {
            $this->selected_sectors = $this->sesuser->getSelectedHRSectorList();
            //$this->sesuser_state = $this->sesuser->getUserProfile()->getSelectedHRState();
        }
        else 
        {
            $this->selected_sectors = BusinessSectorPeer::retrieveByPKs(array_filter(explode('&', $this->getRequest()->getCookie('EMT_HR_SECTORS'))));
            $this->sesuser_state = $this->getRequest()->getCookie('EMT_HR_STATE');
        }
        
        $this->jobs = JobPeer::getFeaturedJobs(24, JobSpecPeer::JSPTYP_SPOT_LISTING);
        $this->platinum = JobPeer::getFeaturedJobs(1, JobSpecPeer::JSPTYP_PLATINUM_LISTING);
        $this->advanced = JobPeer::getFeaturedJobs(2, JobSpecPeer::JSPTYP_ADVANCED_LISTING);
        $this->branded = JobPeer::getFeaturedJobs(4, JobSpecPeer::JSPTYP_BRANDED_LISTING);
        
        $this->network_jobs = $this->sesuser->getConnections(NULL, null, true, true, 8, true, null, null, array('wheres' => array('EMT_JOB.STATUS='.JobPeer::JSTYP_ONLINE)), PrivacyNodeTypePeer::PR_NTYP_JOB);
        shuffle($this->network_jobs);
        
        $this->params = array();
        $this->params['country'] = array();
    }
    
    public function handleError()
    {
    }
    
}
