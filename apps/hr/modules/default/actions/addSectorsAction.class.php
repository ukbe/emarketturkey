<?php

class addSectorsAction extends EmtAction
{
    public function execute($request)
    {
        if (!$this->getRequest()->isXmlHttpRequest())
        {
            $this->renderText($this->getContext()->getI18N()->__('NOT ALLOWED'));
        }
        $this->user = $this->getUser()->getUser();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $sectors = $this->getRequestParameter('sectors');
            $sects = array();
            if ($this->user)
            {
                foreach ($sectors as $sector)
                {
                    if (($sect = BusinessSectorPeer::retrieveByPK($sector)) && !$this->user->hasSelectedHRSector($sector))
                    {
                        $select = new SelectedHRSector();
                        $select->setUserId($this->user->getId());
                        $select->setSectorId($sector);
                        $select->save();
                        $sects[] = $sect;
                    }
                }
                $this->selected_sectors = $sects;
            }
            else
            {
                $selected_sects = array_filter(explode('&', $this->getRequest()->getCookie('EMT_HR_SECTORS')));
                if (!$selected_sects) $selected_sects = array();
                foreach ($sectors as $sector)
                {
                    if (($sect = BusinessSectorPeer::retrieveByPK($sector)) && !in_array($sector, $selected_sects ))
                    {
                        array_push($selected_sects, $sector);
                        $sects[] = $sect;
                    }
                }
                $this->getResponse()->setCookie('EMT_HR_SECTORS', implode('&',$selected_sects), time()+60*60*24*15);
                $this->selected_sectors = $sects;
            }
        }
    }
}