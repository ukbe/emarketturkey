<?php

class ContactPeer extends BaseContactPeer
{
    CONST HOME          = 1;
    CONST WORK          = 2;
    CONST OFFICE        = 3;
    CONST FACTORY       = 4;
    CONST HQ            = 5;
    CONST BRANCH        = 6;
    CONST FAX           = 7;
    CONST MOBILE        = 8;
    
    public static $TextOf = Array(self::HOME    => 'Home',
                                  self::WORK    => 'Work',
                                  self::MOBILE  => 'Mobile',
                                  self::OFFICE  => 'Office',
                                  self::FACTORY => 'Factory',
                                  self::HQ      => 'Headquarters',
                                  self::BRANCH  => 'Branch',
                                  self::FAX     => 'Fax',
                                  );

    public static function textOf($ctype)
    {
        return self::$TextOf[$ctype];
    }
}
