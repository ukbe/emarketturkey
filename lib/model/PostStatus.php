<?php

class PostStatus extends BasePostStatus
{
    private $hash = null;
        
    public function __toString()
    {
        return $this->getMessage();
    }

    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_POST_STATUS;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_POST_STATUS) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getUrl()
    {
        return "@homepage";
    }
}
