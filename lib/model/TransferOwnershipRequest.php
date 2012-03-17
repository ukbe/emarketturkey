<?php

class TransferOwnershipRequest extends BaseTransferOwnershipRequest
{
    public function getAccount()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getAccountId(), $this->getAccountTypeId());
    }
}
