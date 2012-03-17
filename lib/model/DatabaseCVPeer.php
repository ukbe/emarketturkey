<?php

class DatabaseCVPeer extends BaseDatabaseCVPeer
{
    CONST CHANNEL_APPLICATION      = 1;
    CONST CHANNEL_REFERRAL         = 2;
    CONST CHANNEL_SERVICE          = 3;
    
    public static $channelLabels = array (1 => 'Job Application',
                                          2 => 'Referral Signup',
                                          3 => 'CV Database Service'
                                          );
}
