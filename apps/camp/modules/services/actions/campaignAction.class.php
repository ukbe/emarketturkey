<?php

class campaignAction extends EmtAction
{
    public function execute($request)
    {
        if ($request->hasParameter('cid'))
            $this->campaign = CampaignPeer::retrieveByCode($this->getRequestParameter('cid'));
        elseif ($this->getRequestParameter('guid'))
            $this->campaign = CampaignPeer::retrieveByGuid($this->getRequestParameter('guid'));

        if (!$this->campaign)
            $this->redirect('@premium');

        $this->getResponse()->setTitle($this->campaign->getDisplayName());
        $this->type = $this->campaign->getPremiumType();
    }
    
    public function handleError()
    {
    }
    
}
