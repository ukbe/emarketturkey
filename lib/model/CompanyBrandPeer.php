<?php

class CompanyBrandPeer extends BaseCompanyBrandPeer
{
    CONST BRND_NONE                        = 0;
    CONST BRND_HOLDED_BY_COMPANY           = 1;
    CONST BRND_HOLDED_BY_ELSE              = 2;
    
    
    public static $typeNames    = array (0 => 'Not Branded',
                                         1 => 'Owned by Our Company',
                                         2 => 'Owned by Someone Else',
                                  );
}
