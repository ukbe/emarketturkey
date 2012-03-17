<?php

class UserProfilePeer extends BaseUserProfilePeer
{
    CONST MAR_STAT_NA           = 0;
    CONST MAR_STAT_SINGLE       = 1;
    CONST MAR_STAT_MARRIED      = 2;
    
    public static $MaritalStatus = Array(''                         => 'Not Set',
                                         self::MAR_STAT_NA          => 'Not Set',
                                         self::MAR_STAT_SINGLE      => 'Single',
                                         self::MAR_STAT_MARRIED     => 'Married'); 
    
    CONST GENDER_NA             = 0;
    CONST GENDER_MALE           = 1;
    CONST GENDER_FEMALE         = 2;
    
    public static $Gender = Array(''                     => 'Not Set',
                                  self::GENDER_NA        => 'Not Set',
                                  self::GENDER_MALE      => 'Male',
                                  self::GENDER_FEMALE    => 'Female'); 

}
