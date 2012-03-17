<?php

class PaymentPeer extends BasePaymentPeer
{

    CONST PAY_STAT_COMPLETE         = 1;
    CONST PAY_STAT_PENDING          = 2;
    CONST PAY_STAT_BLOCKED          = 3;
    
    public static $typeNames    = array (self::PAY_STAT_COMPLETE => 'Complete',
                                         self::PAY_STAT_PENDING  => 'Pending',
                                         self::PAY_STAT_BLOCKED  => 'Blocked',
                                     );
}
