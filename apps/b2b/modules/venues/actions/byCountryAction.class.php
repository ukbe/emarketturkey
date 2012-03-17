<?php

class byCountryAction extends EmtAction
{
    public function execute($request)
    {
        $this->countries = CountryPeer::getOrderedNames();
    }

    public function handleError()
    {
    }

}
