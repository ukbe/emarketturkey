<?php

class CampaignPeer extends BaseCampaignPeer
{

    public static function retrieveByCode($code, $check_availability = false)
    {
        $c = new Criteria();
        $c->add(CampaignPeer::CODE, $code);
        if ($check_availability)
        {
            // Check conditions for campaign if still available
        }

        return self::doSelectOne($c);
    }

    public static function retrieveByGuid($guid, $check_availability = false)
    {
        $c = new Criteria();
        $c->add(CampaignPeer::GUID, $guid);
        if ($check_availability)
        {
            // Check conditions for campaign if still available
        }

        return self::doSelectOne($c);
    }
    
}
