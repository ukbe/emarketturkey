<?php

class CompanyProfilePeer extends BaseCompanyProfilePeer
{
    CONST FSTYP_SQM         = 1;
    CONST FSTYP_X100M       = 2;
    CONST FSTYP_SQHA        = 3;
    CONST FSTYP_SQFT        = 4;
    CONST FSTYP_SQYD        = 5;
    CONST FSTYP_ACRE        = 6;
    
    public static $fsTypeNames    = array(1 => 'Square Metre',
                                         2 => 'x 1000sqm',
                                         3 => 'Hectare',
                                         4 => 'Square Foot',
                                         5 => 'Square Yard',
                                         6 => 'Acre'
                                         );
    
    CONST MEM_TYP_SELLER    = 1;
    CONST MEM_TYP_BUYER     = 2;
    CONST MEM_TYP_BUYSELL   = 3;
    
    public static $memTypeNames = array(1 => 'Seller',
                                        2 => 'Buyer',
                                        3 => 'Seller & Buyer',
                                        );
    
    CONST EPTYP_00              = 1;
    CONST EPTYP_00_10           = 2;
    CONST EPTYP_10_20           = 3;
    CONST EPTYP_20_30           = 4;
    CONST EPTYP_30_40           = 5;
    CONST EPTYP_40_50           = 6;
    CONST EPTYP_50_60           = 7;
    CONST EPTYP_60_70           = 8;
    CONST EPTYP_70_80           = 9;
    CONST EPTYP_80_90           = 10;
    CONST EPTYP_90_100          = 11;
    
    public static $epTypeNames    = array(1 => '0%',
                                         2 => '0%-10%',
                                         3 => '10%-20%',
                                         4 => '20%-30%',
                                         5 => '30%-40%',
                                         6 => '40%-50%',
                                         7 => '50%-60%',
                                         8 => '60%-70%',
                                         9 => '70%-80%',
                                         10 => '80%-90%',
                                         11 => '90%-100%',
                                         );
                                         
}