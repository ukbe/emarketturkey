<?php

class ContactPhone extends BaseContactPhone
{
    public function __toString()
    {
        return $this->getPhone();
    }
}
