<?php

class WallPost extends BaseWallPost
{
    private $_poster = null;
    private $_item = null;

    public function getPoster()
    {
        return $this->_poster ? $this->_poster : ($this->_poster = PrivacyNodeTypePeer::retrieveObject($this->getPosterId(), $this->getPosterTypeId()));
    }

    public function getItem()
    {
        return $this->_item ? $this->_item : ($this->_item = PrivacyNodeTypePeer::retrieveObject($this->getItemId(), $this->getItemTypeId()));
    }

    public function getPartial()
    {
        return WallPostPeer::$partials[$this->getItemTypeId()];
    }

    public function getHtml()
    {
        sfLoader::loadHelpers('Partial');
        return get_partial(WallPostPeer::$partials[$this->getItemTypeId()], array('post' => $this, 'item' => $this->getItem()));
    }
}