<?php

class upgradeAction extends EmtAction
{
    public function execute($request)
    {
        if ($this->getRequestParameter('type') !== 'gold' && $this->getRequestParameter('type') !== 'platinum')
            $this->redirect('@premium-compare');

        if ($request->hasParameter('cid'))
            $this->campaign = CampaignPeer::retrieveByCode($this->getRequestParameter('cid'));
        elseif ($this->getRequestParameter('guid'))
            $this->campaign = CampaignPeer::retrieveByGuid($this->getRequestParameter('guid'));
        else
            $this->campaign = null;
    }
    
    public function handleError()
    {
    }
    
}
