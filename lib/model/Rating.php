<?php

class Rating extends BaseRating
{
    protected $_item = null;
    
    public function getItem()
    {
        return $this->_item ? $this->_item : ($this->_item = PrivacyNodeTypePeer::retrieveObject($this->getItemId(), $this->getItemTypeId()));
    }
}
