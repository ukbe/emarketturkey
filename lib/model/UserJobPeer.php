<?php

class UserJobPeer extends BaseUserJobPeer
{
    CONST UJTYP_FAVOURITE           = 1;
    CONST UJTYP_APPLIED             = 2;
    
    public static $typeNames    = array (1 => 'Favourite',
                                         2 => 'Applied'
                                         );
    CONST UJ_STAT_TYP_ALL           = 1;
    CONST UJ_STAT_TYP_READ          = 2;
    CONST UJ_STAT_TYP_UNREAD        = 3;
    CONST UJ_STAT_TYP_FAVOURITE     = 4;
    CONST UJ_STAT_TYP_IGNORED       = 5;
    
    public static $statTypeNames = array (1 => 'All',
                                          2 => 'Read',
                                          3 => 'Un-Read',
                                          4 => 'Favourite',
                                          5 => 'Ignored',
                                          );

    CONST UJ_STATUS_PENDING         = 0;
    CONST UJ_STATUS_EVALUATING      = 1;
    CONST UJ_STATUS_REJECTED        = 2;
    CONST UJ_STATUS_EMPLOYED        = 3;
    CONST UJ_STATUS_TERMINATED      = 4;
    
    public static $statusLabels = array (0 => 'Pending',
                                         1 => 'Evaluating',
                                         2 => 'Rejected',
                                         3 => 'Employed',
                                         4 => 'Terminated',
                                         );

    CONST UJ_EMPLYR_FLAG_FAVOURITE  = 1;
    CONST UJ_EMPLYR_FLAG_IGNORE     = 2;
    
    public static $flagTypeNames = array (1 => 'Favorite',
                                          2 => 'Ignored',
                                          );

    public static $flagTypeIcons = array (1 => '/images/layout/icon/led-icons/star_1.png',
                                          2 => '/images/layout/icon/led-icons/hand.png',
                                          );
}
