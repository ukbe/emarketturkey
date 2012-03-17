<?php

class TradeExpertPeer extends BaseTradeExpertPeer
{
    CONST TX_STAT_PENDING           = 1;
    CONST TX_STAT_APPROVED          = 2;
    CONST TX_STAT_DECLINED          = 3;
    CONST TX_STAT_SUSPENDED         = 4;
    
    public static $statLabels   = array (1 => 'Pending',
                                         2 => 'Approved',
                                         3 => 'Declined',
                                         4 => 'Suspended',
                                         );

    public static function retrieveAccountFor($status = null, $holder, $holder_type_id = null)
    {
        if (is_object($holder))
        {
            $holder_id = $holder->getId();
            $holder_type_id = $holder->getObjectTypeId();
        }
        else
        {
            $holder_id = $holder;
        }
        $c = new Criteria();
        $c->add(TradeExpertPeer::HOLDER_ID, $holder_id);
        $c->add(TradeExpertPeer::HOLDER_TYPE_ID, $holder_type_id);
        if ($status) $c->add(TradeExpertPeer::STATUS, $status, is_array($status) ? Criteria::IN : Criteria::EQUAL);
        return TradeExpertPeer::doSelectOne($c);
    }

    public static function getFeaturedTradeExperts($maxnum=20, $type_id = null)
    {
        // @todo: Add an algorithm to select tradeexperts to display on homepage
        $c = new Criteria();
        $c->add(TradeExpertPeer::STATUS, TradeExpertPeer::TX_STAT_APPROVED);
        $c->add(TradeExpertPeer::IS_FEATURED, 1);
        if (isset($type_id)) $c->add(TradeExpertPeer::HOLDER_TYPE_ID, $type_id);
        if (isset($maxnum)) $c->setLimit($maxnum);
        return TradeExpertPeer::doSelect($c);
    }
    
    public static function getTradeExpertFromHash($hash)
    {
        $id = myTools::flipHash($hash, true, PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT);
        return is_numeric($id) && $id!==null && $id!=='' ? self::retrieveByPK($id) : null;
    }

    public static function getTradeExpertFromUrl(sfParameterHolder $ph)
    {
        $app = sfContext::getInstance()->getConfiguration()->getApplication();
        $c = new Criteria();

        $id = myTools::flipHash($ph->get('hash'), true, PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT);

        if (!preg_match("/^\d+$/", $id)) return null;
        $c->add(TradeExpertPeer::ID, $id);
        
        $c->add(TradeExpertPeer::STATUS, TradeExpertPeer::TX_STAT_APPROVED);

        return self::doSelectOne($c);
    }
    
}
