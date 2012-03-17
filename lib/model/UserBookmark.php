<?php

class UserBookmark extends BaseUserBookmark
{
    protected $_object;

    public function getObject()
    {
        return $this->_object ? $this->_object : ($this->_object = PrivacyNodeTypePeer::retrieveObject($this->getItemId(), $this->getItemTypeId()));
    }
}
