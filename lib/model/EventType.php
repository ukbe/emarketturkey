<?php

class EventType extends BaseEventType
{
    public function __toString()
    {
        return $this->getName();
    }
}
