<?php

class selectedSectorsAction extends EmtAction
{
    public function execute($request)
    {
        if (!$this->getRequest()->isXmlHttpRequest())
        {
            $this->renderText('NOT ALLOWED');
        }

        $this->profile = $this->sesuser->getUserProfile();
        if (!$this->sesuser->isNew() && ($this->profile || ($this->profile = $this->sesuser->setupUserProfile())))
        {
            $this->selected_country = $this->profile->getSelectedHRRegion();
            //$this->selected_state = $this->profile->getSelectedHRState();
            $this->sesuser_states = GeonameCityPeer::getCitiesFor($this->selected_country);
            if (($cc = substr($this->getRequestParameter('country_id', '##'), 0, 2)))
            {
                if ($cc != $this->selected_country)
                {
                    $this->profile->setSelectedHRRegion($cc);
                    //$this->profile->setSelectedHRState('');
                    $this->profile->save();
                    $this->selected_country = $cc;
                }
                $this->selected_state = null;
            }
            elseif (($st = $this->getRequestParameter('state_id')) && in_array($st, $this->sesuser_states))
            {
                //if ($st != $this->selected_state)
                {
                    //$this->profile->setSelectedHRState($st);
                    //$this->profile->save();
                }
                $this->selected_state = $st;
            }
            $this->selected_sectors = $this->sesuser->getSelectedHRSectorList();
        }
        else
        {
            $this->selected_country = $this->getRequest()->getCookie('EMT_HR_REGION');
            $this->selected_state = $this->getRequest()->getCookie('EMT_HR_STATE');
            $this->sesuser_states = GeonameCityPeer::getCitiesFor($this->selected_country);
            
            if (($cc = substr($this->getRequestParameter('country_id'), 0, 2)))
            {
                if ($cc != $this->selected_country)
                {
                    $this->getResponse()->setCookie('EMT_HR_REGION', $cc, time()+60*60*24*15, '/');
                    $this->selected_country = $cc;
                }
                $this->selected_state = null;
            }
            elseif (($st = $this->getRequestParameter('state_id')) && in_array($st, array_keys($this->sesuser_states)))
            {
                if ($st != $this->selected_state)
                {
                    $this->getResponse()->setCookie('EMT_HR_STATE', $st, time()+60*60*24*15, '/');
                }
                $this->selected_state = $st;
            }
            $this->selected_sectors = BusinessSectorPeer::retrieveByPKs(array_filter(explode('&', $this->getRequest()->getCookie('EMT_HR_SECTORS'))));
        }
        
    }
}