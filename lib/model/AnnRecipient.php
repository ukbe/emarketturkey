<?php

class AnnRecipient extends BaseAnnRecipient
{
    public function getObject()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getRecipientId(), $this->getRecipientTypeId());
    }
    
}
