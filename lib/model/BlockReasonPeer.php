<?php

class BlockReasonPeer extends BaseBlockReasonPeer
{
    CONST BR_TYP_VERIFICATION_REQUIRED      = 1;
    CONST BR_TYP_UPON_USER_REQUEST          = 2;
    CONST BR_TYP_COURTESY_ENFORCEMENT       = 3;
    
    public static $typeNames    = array (1 => 'Verification Required',
                                         2 => 'Upon User Request',
                                         3 => 'Courtesy Enforcement',
                                         );
}
