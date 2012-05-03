<?php

class MessageRecipient extends BaseMessageRecipient
{
    protected $recipient=null;

    public function getRecipient()
    {
        return $this->recipient ? $this->recipient : ($this->recipient = PrivacyNodeTypePeer::retrieveObject($this->getRecipientId(), $this->getRecipientTypeId()));
    }

    public function setRecipient(& $v)
    {
        $this->recipient = $v;
    }
}
