<?php

class TradeExpertClient extends BaseTradeExpertClient
{
    protected $o_client = null;

    public function getClient()
    {
        return isset($this->o_client) ? $this->o_client : ($this->o_client = PrivacyNodeTypePeer::retrieveObject($this->getClientId(), $this->getClientTypeId()));
    }
}
