<?php

class PlatformAd extends BasePlatformAd
{
    public function  getFile()
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_ADVERTISEMENT);
        $c->addAscendingOrderByColumn(MediaItemPeer::CREATED_AT);
        return MediaItemPeer::doSelectOne($c);
    }

    public function  getFiles()
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_ADVERTISEMENT);
        $c->addAscendingOrderByColumn(MediaItemPeer::CREATED_AT);
        return MediaItemPeer::doSelect($c);
    }

    public function getFileByGuid($guid)
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::GUID, $guid);
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_ADVERTISEMENT);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());
        
        return MediaItemPeer::doSelectOne($c);
    }
    
    public function getInternalFileUri()
    {
        return "@ads.ad_view?guid={$this->getGuid()}";
    }
    
    public function getInternalLinkUrl()
    {
        return "@ads.ad_click?guid={$this->getGuid()}";
    }
    
    public function issueEvent($type_id, $view_id = null)
    {
        $user = sfContext::getInstance()->getUser()->getUser();
        
        $view = new PlatformAdEvent();
        $view->setAdId($this->getId());
        $view->setTypeId($type_id);
        $view->setClientIp(ip2long(sfContext::getInstance()->getRequest()->getHttpHeader('addr', 'remote')));
        $view->setUserId($user ? $user->getId() : null);
        $view->save();
        if (isset($view_id)) 
        {
            $view->setGuid($view_id);
            $view->save();
        }
        else
        {
            $view->reload();
        }
        return $view->getGuid();
    }
    
}
