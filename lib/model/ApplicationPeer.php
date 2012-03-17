<?php

class ApplicationPeer extends BaseApplicationPeer
{
    CONST APP_B2B           = 1;
    CONST APP_HR            = 2;
    CONST APP_AC            = 3;
    CONST APP_CM            = 4;
    CONST APP_TX            = 5;
    
    public static $appNames    = array (self::APP_B2B => 'B2B',
                                        self::APP_HR  => 'Jobs',
                                        self::APP_AC  => 'Academy',
                                        self::APP_CM  => 'Community',
                                        self::APP_TX  => 'Translation'
                                     );
}
