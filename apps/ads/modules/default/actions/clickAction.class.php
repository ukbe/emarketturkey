<?php

class clickAction extends EmtAction
{
    public function execute($request)
    {
        if (!$this->hasRequestParameter('view_id')) return $this->renderText('unavailable');
        
        $c = new Criteria();
        $c->add(PlatformAdPeer::GUID, $this->getRequestParameter('guid'));
        $c->add(PlatformAdPeer::VALID_FROM, time(), Criteria::LESS_THAN);
        $c->add(PlatformAdPeer::VALID_UNTIL, time(), Criteria::GREATER_THAN);
        $c->addJoin(PlatformAdPeer::ID, PlatformAdEventPeer::AD_ID, Criteria::LEFT_JOIN);
        $c->add(PlatformAdEventPeer::GUID, $this->getRequestParameter('view_id'));
        $ad = PlatformAdPeer::doSelectOne($c);

        if (!$ad) return $this->renderText('unavailable');

        $click_id = $ad->issueEvent(PlatformAdEventPeer::PAD_EV_TYP_CLICK, $this->getRequestParameter('view_id'));

        if ($click_id) $this->redirect($ad->getUrl()); else return $this->renderText('unavailable'); 
    }
    
}
