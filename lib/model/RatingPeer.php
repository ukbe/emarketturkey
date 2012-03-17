<?php

class RatingPeer extends BaseRatingPeer
{
    // OBJECT LEVEL TYPES
    CONST RITYP_PRODUCT             = 11;
    CONST RITYP_COMPANY             = 2;
    CONST RITYP_GROUP               = 3;
    CONST RITYP_JOB                 = 23;
    CONST RITYP_B2B_LEAD            = 31;
    CONST RITYP_EVENT               = 32;
    CONST RITYP_TRADE_EXPERT        = 35;
    CONST RITYP_PLACE               = 33;

    public static function logNewVisit($item_id, $item_type_id, $visitor_id = null, $visitor_type_id = null)
    {
        if (!isset($visitor_id) || !isset($visitor_type_id))
        {
            $user = sfContext::getInstance()->getUser()->getUser();
            $visitor_id = ($user->isNew() ? 0 : $user->getId());
            $visitor_type_id = PrivacyNodeTypePeer::PR_NTYP_USER;
        }
        $rate = new Rating();
        $rate->setItemId($item_id);
        $rate->setItemTypeId($item_type_id);
        $rate->setClientIp(sfContext::getInstance()->getRequest()->getHttpHeader('addr', 'remote'));
        $rate->setSessionId(session_id());
        $rate->setVisitorId($visitor_id);
        $rate->setVisitorTypeId($visitor_type_id);
        $rate->save();
    }
    
    public static function getVisitCount($item_id, $item_type_id, $unique=false)
    {
        $con = Propel::getConnection();
        
        if ($unique)
            $sql = "SELECT COUNT(DISTINCT session_id) 
                    FROM EMT_RATING 
                    WHERE ITEM_ID=$item_id AND ITEM_TYPE_ID=$item_type_id";
        else
            $sql = "SELECT COUNT(*) 
                    FROM EMT_RATING 
                    WHERE ITEM_ID=$item_id AND ITEM_TYPE_ID=$item_type_id";
                    
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $rs = $stmt->fetch(PDO::FETCH_NUM);
        return $rs[0];
    }
}