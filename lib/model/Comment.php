<?php

class Comment extends BaseComment
{
    public function getCommenter()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getCommenterId(), $this->getCommenterTypeId());
    }
    
    public function getOwner()
    {
        return $this->getCommenter();
    }
    
    public function getHash()
    {
        return base64_encode($this->getId());
    }
}
