<?php

class PostLink extends BasePostLink
{
    private $hash = null;
        
    public function __toString()
    {
        return $this->getTitle();
    }

    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_POST_LINK;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_POST_LINK) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getImage()
    {
        $c = new Criteria();
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_POST_LINK);
        $c->add(MediaItemPeer::OWNER_ID, $this->getId());

        return MediaItemPeer::doSelectOne($c);
    }
    }
