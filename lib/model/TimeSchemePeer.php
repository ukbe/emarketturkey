<?php

class TimeSchemePeer extends BaseTimeSchemePeer
{
    CONST TS_RTYP_DAILY     = 1;
    CONST TS_RTYP_WEEKLY    = 2;
    CONST TS_RTYP_MONTHLY   = 3;
    CONST TS_RTYP_YEARLY    = 4;
    
    public static $typeNames    = array (1 => 'Daily',
                                         2 => 'Weekly',
                                         3 => 'Monthly',
                                         4 => 'Yearly',
                                    );
}
