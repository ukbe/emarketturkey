<?php

class viewAction extends EmtAction
{
    public function execute($request)
    {
        $c = new Criteria();
        $c->add(PlatformAdPeer::GUID, $this->getRequestParameter('guid'));
        $c->add(PlatformAdPeer::VALID_FROM, time(), Criteria::LESS_THAN);
        $c->add(PlatformAdPeer::VALID_UNTIL, time(), Criteria::GREATER_THAN);
        $c->addJoin(PlatformAdPeer::ID, PlatformAdEventPeer::AD_ID, Criteria::LEFT_JOIN);
        $c->add(PlatformAdEventPeer::GUID, $this->getRequestParameter('view_id'));
        //$c->add(PlatformAdPeer::ID, "SELECT COUNT(EMT_PLATFORM_AD_EVENT.*) WHERE EMT_PLATFORM_AD_EVENT.AD_ID=EMT_PLATFORM_AD.ID AND EMT_PLATFORM_AD_EVENT.TYPE_ID=".PlatformAdEventPeer::PAD_EV_TYP_VIEW. " < EMT_PLATFORM_AD.VIEW_LIMIT", Criteria::CUSTOM);
        $ad = PlatformAdPeer::doSelectOne($c);
        
        if (!$ad) return $this->renderText('unavailable');
/*        
        $view = new PlatformAdEvent();
        $view->setAdId($ad->getId());
        $view->setTypeId(PlatformAdEventPeer::PAD_EV_TYP_VIEW);
        $view->setClientIp(ip2long($this->getRequest()->getHttpHeader('addr', 'remote')));
        $view->setUserId($this->sesuser->getId());
        $view->save();
*/
        $file = $ad->getFile();
        
        $fp = fopen($file->getPath(), 'rb');

        $mime = mime_content_type($file->getPath());
        // send the right headers
        header("Content-Type: $mime");
        header("Content-Length: " . filesize($file->getPath()));
        
        // dump the file and stop the script
        fpassthru($fp);
        exit;
    }
    
}
