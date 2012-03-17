<?php

class GeonameCountryPeer extends BaseGeonameCountryPeer
{
    public static function retrieveByISO($iso_code)
    {
        $c = new Criteria();
        $c->add(GeonameCountryPeer::ISO, $iso_code);
        return self::doSelectOne($c);
    }
}
