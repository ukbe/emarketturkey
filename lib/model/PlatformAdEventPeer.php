<?php

class PlatformAdEventPeer extends BasePlatformAdEventPeer
{
    CONST PAD_EV_TYP_VIEW                   = 1;
    CONST PAD_EV_TYP_CLICK                  = 2;
    
    public static $typeNames    = array (1 => 'View',
                                         2 => 'Click',
                                         );
    
}
