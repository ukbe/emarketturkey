<?php

class ContactAddress extends BaseContactAddress
{
    public function __toString()
    {
        $addr = array();
        $addr[] = $this->getStreet();
        $addr[] = $this->getCity();
        $addr[] = $this->getGeonameCity();
        $addr[] = $this->getPostalCode();
        $addr[] = $this->getCountry();
        $str = implode(',', $addr);

        return $str;
    }
}
