<?php

class MessageType extends BaseMessageType
{
    public function __toString()
    {
        return $this->getName(); 
    }
    
}
