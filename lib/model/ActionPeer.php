<?php

class ActionPeer extends BaseActionPeer
{
    // ATTENTION: CONSTANTS STARTING WITH EMT ARE OLD VERSIONS ARE TO BE REMOVED AS SOON AS POSSIBLE.
    //            CLASSIFIED CONSTANTS SHOULD BE USED, INSTEAD.
    CONST EMT_ACT_VIEW_DETAILED_PROFILE     = 1;
    CONST EMT_ACT_VIEW_SHORT_PROFILE        = 2;
    CONST EMT_ACT_VIEW_FRIENDS              = 3;
    CONST EMT_ACT_SEND_MESSAGE              = 4;
    CONST EMT_ACT_ADD_AS_FRIEND             = 5;
    CONST EMT_ACT_CREATE_CV                 = 6;
    CONST EMT_ACT_VIEW_CV                   = 7;
    CONST EMT_ACT_LOG_IN                    = 8;
    CONST EMT_ACT_CHANG_PASSWORD            = 12;
    CONST EMT_ACT_UPD_PROFILE_PIC           = 15;
    CONST EMT_ACT_UPLOAD_PHOTO              = 18;
    CONST EMT_ACT_UPD_HR_LOGO               = 19;
    CONST EMT_ACT_SET_USERNAME              = 20;
    CONST EMT_ACT_UPD_ACNT_INFO             = 21;
    CONST EMT_ACT_JOIN_GROUP                = 22;
    
    CONST EMT_ACT_UPD_CORP_INFO             = 9;
    CONST EMT_ACT_UPD_CNTCT_INFO            = 10;
    CONST EMT_ACT_ADD_PRODUCT               = 11;
    CONST EMT_ACT_UPD_PROD_INFO             = 13;
    CONST EMT_ACT_POST_JOB                  = 14;
    CONST EMT_ACT_UPD_LOGO                  = 16;
    CONST EMT_ACT_CREATE_HR_PROF            = 17;
    
    /*  Action Constants:
    */
    
    CONST ACT_VIEW_PROFILE                  = 1;
    CONST ACT_VIEW_PUBLIC_PROFILE           = 2;
    CONST ACT_VIEW_FRIENDS                  = 3;
    CONST ACT_VIEW_GROUPS                   = 4;
    CONST ACT_VIEW_FOLLOWS                  = 5;
    CONST ACT_VIEW_PERSONAL_INFO            = 6;
    CONST ACT_UPDATE_PERSONAL_INFO          = 7;
    CONST ACT_VIEW_CONTACT_INFO             = 8;
    CONST ACT_UPDATE_CONTACT_INFO           = 9;
    CONST ACT_VIEW_CAREER                   = 10;
    CONST ACT_SEND_MESSAGE                  = 11;
    CONST ACT_POST_WALL                     = 12;
    CONST ACT_COMMENT_ASSET                 = 13;
    CONST ACT_VIEW_FOLLOWERS                = 14;
    CONST ACT_VIEW_PEOPLE                   = 15;
    CONST ACT_VIEW_COMPANIES                = 16;
    CONST ACT_ADD_TO_NETWORK                = 17;
    CONST ACT_FOLLOW_COMPANY                = 18;
    CONST ACT_JOIN_GROUP                    = 19;
    CONST ACT_VIEW_PHOTOS                   = 20;
    CONST ACT_VIEW_EVENTS                   = 21;
    CONST ACT_CREATE_RESUME                 = 22;
    CONST ACT_CREATE_COMPANY                = 23;
    CONST ACT_UPDATE_CORPORATE_INFO         = 24;
    CONST ACT_UPLOAD_PHOTO                  = 25;
    CONST ACT_MANAGE_FOLLOWERS              = 26;
    CONST ACT_CREATE_EVENT                  = 27;
    CONST ACT_CREATE_GROUP                  = 28;
    CONST ACT_UPDATE_GROUP_INFO             = 29;
    CONST ACT_MANAGE_MEMBERS                = 30;
    CONST ACT_INVITE_TO_EVENT               = 31;
    CONST ACT_INVITE_TO_GROUP               = 32;
    CONST ACT_UPLOAD_PROFILE_PICTURE        = 33;
    CONST ACT_UPLOAD_LOGO                   = 34;
    CONST ACT_LOG_IN                        = 35;
    CONST ACT_CHANGE_PASSWORD               = 36;
    CONST ACT_UPLOAD_HR_LOGO                = 37;
    CONST ACT_SET_USERNAME                  = 38;
    CONST ACT_ADD_PRODUCT                   = 39;
    CONST ACT_UPDATE_PRODUCT                = 40;
    CONST ACT_POST_JOB                      = 41;
    CONST ACT_CREATE_HR_PROFILE             = 42;
    CONST ACT_VIEW_GROUP_INFORMATION        = 43;
    CONST ACT_LEAVE_GROUP                   = 44;
    CONST ACT_MANAGE_GROUP                  = 45;
    CONST ACT_UPDATE_ACCOUNT_INFO           = 46;
    CONST ACT_UPDATE_STATUS_MESSAGE         = 47;
    CONST ACT_UPDATE_LOCATION               = 48;
    CONST ACT_ACCEPT_FRIENDSHIP_REQUEST     = 49;
    CONST ACT_UPDATE_RELATION_STATUS        = 50;
    CONST ACT_ACCEPT_RELATION_STATUS_UPDATE = 51;
    CONST ACT_POST_SELLING_LEAD             = 52;
    CONST ACT_POST_BUYING_LEAD              = 53;
    CONST ACT_EXPRESS_EVENT_ATTENDANCE      = 54;
    CONST ACT_START_DISCUSSION              = 55;
    CONST ACT_PARTICIPATE_DISCUSSION        = 56;
    CONST ACT_BROWSE_MEMBERS                = 57;
    CONST ACT_SEND_MESSAGE_AS               = 58;
    CONST ACT_SEND_SMS_AS                   = 59;
    CONST ACT_CHANGE_PERMISSIONS            = 60;
    CONST ACT_EVALUATE_MEMBERS              = 61;
    CONST ACT_MAKE_ANNOUNCEMENT             = 62;
    CONST ACT_START_POLL                    = 63;
    CONST ACT_VOTE_ON_POLL                  = 64;
    
    public static function getActionsAs($object_type_id, $subject_type_id = null, $get_only_controllables = false, $act_filter = null)
    {
        $c = new Criteria();
        $c->addJoin(ActionPeer::ID, ActionCasePeer::ACTION_ID);
        if (isset($subject_type_id)) $c->add(ActionCasePeer::ISSUER_TYPE_ID, $subject_type_id);
        if (isset($object_type_id)) $c->add(ActionCasePeer::TARGET_TYPE_ID, $object_type_id);
        if ($get_only_controllables) $c->add(ActionPeer::PRIVACY_CONTROLLED, 1);
        if (is_array($act_filter)) $c->add(ActionPeer::ID, $act_filter, Criteria::IN);
        return self::doSelect($c);
    }
    
    public static function getActionsAsSubject($subject_type_id)
    {
        $c = new Criteria();
        $c->addJoin(ActionPeer::ID, ActionCasePeer::ACTION_ID);
        $c->addJoin(ActionPeer::ID, ActionI18nPeer::ID);
        $c->addAscendingOrderByColumn(ActionI18nPeer::NAME);
        $c->add(ActionCasePeer::ISSUER_TYPE_ID, $subject_type_id);
        $c->setDistinct();
        return self::doSelect($c);
    }
    
}

