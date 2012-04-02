<?php

class PrivacyNodeTypePeer extends BasePrivacyNodeTypePeer
{
    // SHORTCUTS FOR RELATION TYPES STORED IN DB
    
    // OBJECT LEVEL TYPES
    CONST PR_NTYP_USER              = 1;
    CONST PR_NTYP_COMPANY           = 2;
    CONST PR_NTYP_GROUP             = 3;
    // GENERIC TYPES
    CONST PR_NTYP_EVERYONE          = 4;
    CONST PR_NTYP_NETWORK_MEMBER    = 5;
    // RELATIONAL TYPES
    CONST PR_NTYP_FAMILY_MEMBER     = 6;
    CONST PR_NTYP_COLLEAGUE         = 7;
    CONST PR_NTYP_PARTNER_COMPANY   = 8;
    // RELATIONAL SUPER TYPES
    CONST PR_NTYP_NETWORK_COMPANY   = 9;
    CONST PR_NTYP_NETWORK_USER      = 10;
    CONST PR_NTYP_PRODUCT           = 11;
    CONST PR_NTYP_PUBLICATION       = 12;
    CONST PR_NTYP_PUBLICATION_SOURCE= 13;
    CONST PR_NTYP_AUTHOR            = 14;
    CONST PR_NTYP_MEDIA_ITEM        = 15;
    CONST PR_NTYP_MEDIA_ITEM_FOLDER = 16;
    CONST PR_NTYP_COMMENT           = 17;
    CONST PR_NTYP_ACTION_LOG        = 18;
    CONST PR_NTYP_STATUS_UPDATE     = 19;
    CONST PR_NTYP_LOCATION_UPDATE   = 20;
    CONST PR_NTYP_REL_STAT_UPDATE   = 21;
    CONST PR_NTYP_POLL_ITEM         = 22;
    CONST PR_NTYP_JOB               = 23;
    CONST PR_NTYP_WALL_POST         = 24;
    CONST PR_NTYP_POST_LINK         = 25;
    CONST PR_NTYP_POST_VIDEO        = 26;
    CONST PR_NTYP_POST_JOB          = 27;
    CONST PR_NTYP_POST_OPPORTUNITY  = 28;
    CONST PR_NTYP_LIKE_IT           = 29;
    CONST PR_NTYP_ADVERTISEMENT     = 30;
    CONST PR_NTYP_B2B_LEAD          = 31;
    CONST PR_NTYP_EVENT             = 32;
    CONST PR_NTYP_PLACE             = 33;
    CONST PR_NTYP_EVENT_INVITE      = 34;
    CONST PR_NTYP_TRADE_EXPERT      = 35;
    CONST PR_NTYP_USER_JOB          = 36;
    CONST PR_NTYP_PUBLICATION_CATEGORY= 37;
    CONST PR_NTYP_TRANSLATOR        = 38;
    CONST PR_NTYP_POST_LOCATION     = 39;

    public static $typeNames    = array (1 => 'User',
                                         2 => 'Company',
                                         3 => 'Group',
                                         4 => 'Everyone',
                                         5 => 'Network Member',
                                         6 => 'Family Member',
                                         7 => 'Colleague',
                                         8 => 'Partner Company',
                                         9 => 'Network Company',
                                         10 => 'Network User',
                                         11 => 'Product',
                                         12 => 'Publication',
                                         13 => 'Publication Source',
                                         14 => 'Author',
                                         15 => 'Media Item',
                                         16 => 'Media Item Folder',
                                         17 => 'Comment',
                                         18 => 'Action Log',
                                         19 => 'Status Update',
                                         20 => 'Location Update',
                                         21 => 'Relation Update',
                                         22 => 'Poll Item',
                                         23 => 'Job',
                                         24 => 'Wall Post',
                                         25 => 'Post Link',
                                         26 => 'Post Video',
                                         27 => 'Post Job',
                                         28 => 'Post Opportunity',
                                         29 => 'Like',
                                         30 => 'Advertisement',
                                         31 => 'B2B Lead',
                                         32 => 'Event',
                                         33 => 'Place',
                                         34 => 'Event Invite',
                                         35 => 'Trade Expert',
                                         36 => 'User Job',
                                         37 => 'Publication Category',
                                         38 => 'Translator',
                                         39 => 'Post Location',
                                         );
    public static $matrix       = array('User'      => self::PR_NTYP_USER,
                                        'Company'   => self::PR_NTYP_COMPANY,
                                        'Group'     => self::PR_NTYP_GROUP,
                                        'MediaItem' => self::PR_NTYP_MEDIA_ITEM,
                                        'MediaItemFolder' => self::PR_NTYP_MEDIA_ITEM_FOLDER,
                                        'Comment'   => self::PR_NTYP_COMMENT,
                                        'ActionLog'   => self::PR_NTYP_ACTION_LOG,
                                        'StatusUpdate'   => self::PR_NTYP_STATUS_UPDATE,
                                        'LocationUpdate'   => self::PR_NTYP_LOCATION_UPDATE,
                                        'RelationUpdate'   => self::PR_NTYP_REL_STAT_UPDATE,
                                        'Product'   => self::PR_NTYP_PRODUCT,
                                        'PollItem'  => self::PR_NTYP_POLL_ITEM,
                                        'Publication'  => self::PR_NTYP_PUBLICATION,
                                        'Job'       => self::PR_NTYP_JOB,
                                        'WallPost' => self::PR_NTYP_WALL_POST,
                                        'PostLink' => self::PR_NTYP_POST_LINK,
                                        'PostVideo' => self::PR_NTYP_POST_VIDEO,
                                        'PostJob'  => self::PR_NTYP_POST_JOB,
                                        'PostOpportunity' => self::PR_NTYP_POST_OPPORTUNITY,
                                        'LikeIt'       => self::PR_NTYP_LIKE_IT,
                                        'PlatformAd'       => self::PR_NTYP_ADVERTISEMENT,
                                        'B2bLead'       => self::PR_NTYP_B2B_LEAD,
                                        'Event'       => self::PR_NTYP_EVENT,
                                        'Place'       => self::PR_NTYP_PLACE,
                                        'EventInvite' => self::PR_NTYP_EVENT_INVITE,
                                        'TradeExpert' => self::PR_NTYP_TRADE_EXPERT,
                                        'UserJob' => self::PR_NTYP_USER_JOB,
                                        'PublicationCategory' => self::PR_NTYP_PUBLICATION_CATEGORY,
                                        'Translator' => self::PR_NTYP_TRANSLATOR,
                                        'PostLocation' => self::PR_NTYP_POST_LOCATION,
                                        );

    public static function getTypeFromClassname($classname, $return_obj = false)
    {
        if (!is_string($classname)) $classname = get_class($classname);
        return array_key_exists($classname, self::$matrix) ? ($return_obj ? PrivacyNodeTypePeer::retrieveByPK(self::$matrix[$classname]) : self::$matrix[$classname]) : null;
    }
    
    public static function getObjectTypeName($object, $culture = null)
    {
        $culture = (isset($culture) ? $culture : sfContext::getInstance()->getUser()->getCulture());
        $type = self::getTypeFromClassname($object);
        return ($pntyp = self::retrieveByPK($type)) ? $pntyp->getName($culture) : '#UNDEFINED#';
    }
    
    public static function getOrderedObjectNames()
    {
        $c = new Criteria();
        $c->add(PrivacyNodeTypePeer::REQUIRES_SUBJECT, 1);
        $c->addAscendingOrderByColumn(PrivacyNodeTypeI18nPeer::NAME);
        $c->setDistinct();
        return self::doSelectWithI18n($c);
    }
    
    public static function retrieveObject($item_id, $item_type_id)
    {
        if (!$item_id || !$item_type_id) return null;
        $flipped = array_flip(self::$matrix);

        return call_user_func($flipped[$item_type_id] . "Peer::retrieveByPK", $item_id);
    }
    
    public static function getObjectUrl($object)
    {
        switch (self::getTypeFromClassname($object))
        {
            case self::PR_NTYP_MEDIA_ITEM   : return $object->getUri();
                                              break;
            case self::PR_NTYP_PRODUCT      : return $object->getUrl();
                                              break;
            case self::PR_NTYP_GROUP        : return $object->getProfileUrl();
                                              break;
            case self::PR_NTYP_USER         : return $object->getProfileUrl();
                                              break;
            case self::PR_NTYP_COMPANY      : return $object->getProfileUrl();
                                              break;
            case self::PR_NTYP_PUBLICATION  : return $object->getUrl();
                                              break;
            case self::PR_NTYP_MEDIA_ITEM   : return $object->getUri();
                                              break;
            case self::PR_NTYP_AUTHOR       : return $object->getUrl();
                                              break;
            case self::PR_NTYP_STATUS_UPDATE : return $object->getUrl();
                                              break;
            case self::PR_NTYP_LOCATION_UPDATE : return $object->getUrl();
                                              break;
            case self::PR_NTYP_JOB          : return $object->getUrl();
                                              break;
            case self::PR_NTYP_B2B_LEAD     : return $object->getUrl();
                                              break;
            case self::PR_NTYP_EVENT        : return $object->getUrl();
                                              break;
            case self::PR_NTYP_PLACE        : return $object->getUrl();
                                              break;
            case self::PR_NTYP_TRADE_EXPERT : return $object->getProfileUrl();
                                              break;
            default                         : return null;
        }
    }
    
    public static function objectHasAdjective($object)
    {
        switch (self::getTypeFromClassname($object))
        {
            case self::PR_NTYP_MEDIA_ITEM   : return false;
                                              break;
            case self::PR_NTYP_PRODUCT      : return false;
                                              break;
            case self::PR_NTYP_GROUP        : return true;
                                              break;
            case self::PR_NTYP_USER         : return true;
                                              break;
            case self::PR_NTYP_COMPANY      : return true;
                                              break;
            case self::PR_NTYP_PUBLICATION  : return true;
                                              break;
            case self::PR_NTYP_MEDIA_ITEM   : return false;
                                              break;
            case self::PR_NTYP_AUTHOR       : return true;
                                              break;
            case self::PR_NTYP_STATUS_UPDATE : return false;
                                              break;
            case self::PR_NTYP_LOCATION_UPDATE : return false;
                                              break;
            case self::PR_NTYP_REL_STAT_UPDATE : return false;
                                              break;
            case self::PR_NTYP_JOB          : return false;
                                              break;
            case self::PR_NTYP_B2B_LEAD     : return false;
                                              break;
            default                         : return null;
        }
    }
    
    public static function getTopOwnerOf($item)
    {
        $pin = $item;
        while ($pin && PrivacyNodeTypePeer::getTypeFromClassname($pin) != PrivacyNodeTypePeer::PR_NTYP_USER)
        {
            $pin = $pin->getOwner();
        }
        return $pin;
    }
}
