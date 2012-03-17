<?php

class UserCompanyPeer extends BaseUserCompanyPeer
{
    CONST UCTYP_FAVOURITE           = 1;
    CONST UCTYP_BANNED              = 2;
    
    public static $typeNames    = array (1 => 'Favourite',
                                         2 => 'Banned'
                                         );
}
