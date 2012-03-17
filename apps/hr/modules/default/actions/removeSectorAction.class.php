<?php

class removeSectorAction extends EmtAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();
        
        //if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $sector = $this->getRequestParameter('sector_id');
            $sects = array();
            if ($this->user)
            {
                if ($this->user->hasSelectedHRSector($sector))
                {
                    $sect = $this->user->getSelectedHRSector($sector);
                    $sect->delete();
                }
            }
            else
            {
                $selected_sects = array_filter(explode('&', $this->getRequest()->getCookie('EMT_HR_SECTORS')));
                if (!$selected_sects) $selected_sects = array();
                if (($sect = BusinessSectorPeer::retrieveByPK($sector)) && in_array($sector, $selected_sects ))
                {
                    $selected_sects = array_diff($selected_sects, array($sector));
                }
                $this->getResponse()->setCookie('EMT_HR_SECTORS', implode('&',$selected_sects), time()+60*60*24*15);
            }
        }
        
        if (!$this->getRequest()->isXmlHttpRequest())
        {
            $this->redirect($this->_ref ? $this->_ref : $this->refUrl);
        }
    }
}