<?php

class MessageRecipient extends BaseMessageRecipient
{
    protected $recipient=null;

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function setRecipient(& $v)
    {
        $this->recipient = $v;
    }
}
