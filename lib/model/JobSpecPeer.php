<?php

class JobSpecPeer extends BaseJobSpecPeer
{
    CONST JSPTYP_JOB_FUNCTION       = 1;
    CONST JSPTYP_WORKING_SCHEME     = 2;
    CONST JSPTYP_JOB_GRADE          = 3;
    CONST JSPTYP_SCHOOL_DEGREE      = 4;
    CONST JSPTYP_GENDER             = 5;
    CONST JSPTYP_EXPERIENCE_YEAR    = 6;
    CONST JSPTYP_SPECIAL_CASE       = 7;
    CONST JSPTYP_SMOKING_STATUS     = 8;
    CONST JSPTYP_DRIVERS_LICENSE    = 9;
    CONST JSPTYP_TRAVEL_PERCENT     = 10;
    CONST JSPTYP_MILSERV_STATUS     = 11;
    CONST JSPTYP_MILSERV_POSTYEAR   = 12;
    CONST JSPTYP_PUBLISHED_ON       = 13;
    CONST JSPTYP_ONLINE_DAYS_LIMIT  = 14;
    CONST JSPTYP_SPOT_LISTING       = 15;
    CONST JSPTYP_ADVANCED_LISTING   = 16;
    CONST JSPTYP_PLATINUM_LISTING   = 17;
    CONST JSPTYP_BRANDED_LISTING    = 18;

    CONST JSP_MILSERV_DOESNTMATTER  = 1;
    CONST JSP_MILSERV_PERFORMED     = 2;
    CONST JSP_MILSERV_POSTPONED     = 3;

    public static $typeNames        = array(self::JSPTYP_JOB_FUNCTION     => 'Job Function',
                                            self::JSPTYP_WORKING_SCHEME   => 'Attendence',
                                            self::JSPTYP_JOB_GRADE        => 'Position Level',
                                            self::JSPTYP_SCHOOL_DEGREE    => 'Education Level',
                                            self::JSPTYP_GENDER           => 'Gender',
                                            self::JSPTYP_EXPERIENCE_YEAR  => 'Experience',
                                            self::JSPTYP_SPECIAL_CASE     => 'Special Case',
                                            self::JSPTYP_SMOKING_STATUS   => 'Smoking Status',
                                            self::JSPTYP_DRIVERS_LICENSE  => "Driver's License",
                                            self::JSPTYP_TRAVEL_PERCENT   => 'Travel Percent',
                                            self::JSPTYP_MILSERV_STATUS   => 'Military Service Status',
                                            self::JSPTYP_MILSERV_POSTYEAR => 'Military Service Postponed For',
                                            self::JSPTYP_PUBLISHED_ON     => 'Published On',
                                            self::JSPTYP_ONLINE_DAYS_LIMIT=> 'Online Days Limit',
                                            self::JSPTYP_SPOT_LISTING     => 'Spot Job Listing',
                                            self::JSPTYP_ADVANCED_LISTING => 'Advanced Job Listing',
                                            self::JSPTYP_PLATINUM_LISTING => 'Platinum Job Listing',
                                            self::JSPTYP_BRANDED_LISTING  => 'Branded Job Listing',
                                            );

    public static $typeLimits       = array(self::JSPTYP_JOB_FUNCTION     => 1,
                                            self::JSPTYP_WORKING_SCHEME   => 1,
                                            self::JSPTYP_JOB_GRADE        => 1,
                                            self::JSPTYP_SCHOOL_DEGREE    => 0,
                                            self::JSPTYP_GENDER           => 1,
                                            self::JSPTYP_EXPERIENCE_YEAR  => 1,
                                            self::JSPTYP_SPECIAL_CASE     => 0,
                                            self::JSPTYP_SMOKING_STATUS   => 1,
                                            self::JSPTYP_DRIVERS_LICENSE  => 4,
                                            self::JSPTYP_TRAVEL_PERCENT   => 1,
                                            self::JSPTYP_MILSERV_STATUS   => 1,
                                            self::JSPTYP_MILSERV_POSTYEAR => 1,
                                            self::JSPTYP_PUBLISHED_ON     => 1,
                                            self::JSPTYP_ONLINE_DAYS_LIMIT=> 1,
                                            self::JSPTYP_SPOT_LISTING     => 1,
                                            self::JSPTYP_ADVANCED_LISTING => 1,
                                            self::JSPTYP_PLATINUM_LISTING => 1,
                                            self::JSPTYP_BRANDED_LISTING  => 1,
                                            );

    public static $milServLabels    = array(self::JSP_MILSERV_DOESNTMATTER => "Doesn't matter",
                                            self::JSP_MILSERV_PERFORMED    => 'Performed',
                                            self::JSP_MILSERV_POSTPONED    => 'Postponed',
                                            );

    public static $experienceLabels = array(1 => '%1 Years',
                                            2 => '%1 Years',
                                            4 => '%1 Years',
                                            5 => '%1 Years',
                                            6 => '%1 Years',
                                            7 => '%1 Years',
                                            8 => '%1 Years',
                                            9 => '%1 Years',
                                            10 => '%1 Years',
                                            11 => '1..5 Years',
                                            12 => '6..10 Years',
                                            13 => '11..15 Years',
                                            14 => '15..20 Years',
                                            );

}
