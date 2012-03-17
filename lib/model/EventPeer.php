<?php

class EventPeer extends BaseEventPeer
{
    CONST EVN_PRTYP_PAST        = 1;
    CONST EVN_PRTYP_TODAY       = 2;
    CONST EVN_PRTYP_THIS_WEEK   = 3;
    CONST EVN_PRTYP_NEXT_WEEK   = 4;
    CONST EVN_PRTYP_FUTURE      = 5;
    
    CONST EVN_ATTYP_PENDING       = 0;
    CONST EVN_ATTYP_ATTENDING     = 1;
    CONST EVN_ATTYP_NOT_ATTENDING = 2;
    CONST EVN_ATTYP_MAYBE         = 3;

    public static $rtypNames = array(self::EVN_PRTYP_PAST       => 'Past',
                                     self::EVN_PRTYP_TODAY      => 'Today',
                                     self::EVN_PRTYP_THIS_WEEK  => 'This Week',
                                     self::EVN_PRTYP_NEXT_WEEK  => 'Next Week',
                                     self::EVN_PRTYP_FUTURE     => 'Future',
                               );
    
    public static $attypNames = array(self::EVN_ATTYP_PENDING       => 'Pending',
                                      self::EVN_ATTYP_ATTENDING       => 'Attending',
                                      self::EVN_ATTYP_NOT_ATTENDING    => 'Not Attending',
                                      self::EVN_ATTYP_MAYBE            => 'Maybe',
                               );
    
    public static $sqls = array(
        
        EventPeer::EVN_PRTYP_TODAY => "
            SELECT EMT_EVENT.* FROM EMT_EVENT 
            LEFT JOIN EMT_TIME_SCHEME ON EMT_EVENT.TIME_SCHEME_ID=EMT_TIME_SCHEME.ID
            WHERE TRUNC(EMT_TIME_SCHEME.START_DATE) = TRUNC(SYSDATE) AND
                  OWNER_TYPE_ID=:OWNER_TYPE_ID AND OWNER_ID=:OWNER_ID
            ORDER BY EMT_TIME_SCHEME.START_DATE ASC",
        EventPeer::EVN_PRTYP_THIS_WEEK => "
            SELECT EMT_EVENT.* FROM EMT_EVENT 
            LEFT JOIN EMT_TIME_SCHEME ON EMT_EVENT.TIME_SCHEME_ID=EMT_TIME_SCHEME.ID
            WHERE TRUNC(EMT_TIME_SCHEME.START_DATE) > TRUNC(SYSDATE) AND
                  TRUNC(EMT_TIME_SCHEME.START_DATE) < TRUNC(NEXT_DAY(SYSDATE, 'MONDAY')) AND
                  OWNER_TYPE_ID=:OWNER_TYPE_ID AND OWNER_ID=:OWNER_ID
            ORDER BY EMT_TIME_SCHEME.START_DATE ASC",
        EventPeer::EVN_PRTYP_NEXT_WEEK => "
            SELECT EMT_EVENT.* FROM EMT_EVENT 
            LEFT JOIN EMT_TIME_SCHEME ON EMT_EVENT.TIME_SCHEME_ID=EMT_TIME_SCHEME.ID
            WHERE TRUNC(EMT_TIME_SCHEME.START_DATE) >= TRUNC(NEXT_DAY(SYSDATE, 'MONDAY')) AND
                  TRUNC(EMT_TIME_SCHEME.START_DATE) < TRUNC(NEXT_DAY(SYSDATE, 'MONDAY')+7) AND
                  OWNER_TYPE_ID=:OWNER_TYPE_ID AND OWNER_ID=:OWNER_ID
            ORDER BY EMT_TIME_SCHEME.START_DATE ASC",
        EventPeer::EVN_PRTYP_FUTURE => "
            SELECT EMT_EVENT.* FROM EMT_EVENT 
            LEFT JOIN EMT_TIME_SCHEME ON EMT_EVENT.TIME_SCHEME_ID=EMT_TIME_SCHEME.ID
            WHERE TRUNC(EMT_TIME_SCHEME.START_DATE) >= TRUNC(SYSDATE) AND
                  OWNER_TYPE_ID=:OWNER_TYPE_ID AND OWNER_ID=:OWNER_ID
            ORDER BY EMT_TIME_SCHEME.START_DATE ASC",
        EventPeer::EVN_PRTYP_PAST => "
            SELECT EMT_EVENT.* FROM EMT_EVENT 
            LEFT JOIN EMT_TIME_SCHEME ON EMT_EVENT.TIME_SCHEME_ID=EMT_TIME_SCHEME.ID
            WHERE TRUNC(EMT_TIME_SCHEME.START_DATE) < TRUNC(SYSDATE) AND
                  OWNER_TYPE_ID=:OWNER_TYPE_ID AND OWNER_ID=:OWNER_ID
            ORDER BY EMT_TIME_SCHEME.START_DATE ASC"
    );
    
    public static function getEventFromUrl(sfParameterHolder $ph, $filter_env = true)
    {
        $app = sfContext::getInstance()->getConfiguration()->getApplication();
        $c = new Criteria();
        
        if ($app == 'myemt')
        {
            if (!preg_match("/^\d+$/", $ph->get('id'))) return null;
            $c->add(EventPeer::ID, $ph->get('id'));
        }
        else
        {
            if (!preg_match("/^[A-Fa-f0-9]+$/", $ph->get('guid'))) return null;
            $c->add(EventPeer::GUID, $ph->get('guid'));
        }

        if ($filter_env && $app != 'myemt')
        {
            $c->addJoin(EventPeer::TYPE_ID, EventTypePeer::ID, Criteria::LEFT_JOIN);
            switch ($app)
            {
                case 'b2b' : 
                    $c1 = $c->getNewCriterion(EventTypePeer::TYPE_CLASS, EventTypePeer::ECLS_TYP_BUSINESS);
                    break;
                case 'cm' : 
                    $c1 = $c->getNewCriterion(EventTypePeer::TYPE_CLASS, EventTypePeer::ECLS_TYP_SOCIAL);
                    break;
                case 'ac' : 
                    $c1 = $c->getNewCriterion(EventTypePeer::TYPE_CLASS, EventTypePeer::ECLS_TYP_ACADEMIC);
                    break;
            }
            
            $c2 = $c->getNewCriterion(EventTypePeer::TYPE_CLASS, null, Criteria::ISNULL);
            $c1->addOr($c2);
            $c->addAnd($c1);
        }

        return self::doSelectOne($c);
    }

    public static function getFeaturedEvents($num = null, $class_type = null, $c1 = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }
        $c->addJoin(EventPeer::TYPE_ID, EventTypePeer::ID);
        $c->addJoin(EventPeer::TIME_SCHEME_ID, TimeSchemePeer::ID);
        
        if ($class_type)
        {
            $c2 = $c->getNewCriterion(EventTypePeer::TYPE_CLASS, $class_type);
            $c3 = $c->getNewCriterion(EventTypePeer::TYPE_CLASS, null, Criteria::ISNULL);
            $c2->addOr($c3);
            $c->addAnd($c2);
        }
        
        $c->add(TimeSchemePeer::END_DATE, 'TRUNC(EMT_TIME_SCHEME.END_DATE) >= TRUNC(SYSDATE)', Criteria::CUSTOM);
        $c->add(EventPeer::IS_FEATURED, 1);
        $c->addAscendingOrderByColumn(TimeSchemePeer::START_DATE);
        if (isset($num)) $c->setLimit($num);
        
        return EventPeer::doSelect($c);
    }
}
