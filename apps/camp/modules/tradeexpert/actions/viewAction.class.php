<?php

class viewAction extends EmtTradeExpertAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle($this->tradeexpert->__toString() . ' | eMarketTurkey');
        
        $this->areas = $this->tradeexpert->getAreas();
        $this->industries = $this->tradeexpert->getIndustries();
        $c = new Criteria();
        $c->addJoin(array(TradeExpertClientPeer::CLIENT_ID, TradeExpertClientPeer::CLIENT_TYPE_ID), array(MediaItemPeer::OWNER_ID, MediaItemPeer::OWNER_TYPE_ID), Criteria::LEFT_JOIN);
        $c->add(MediaItemPeer::ID, null, Criteria::ISNOTNULL);
        
        $this->clients = $this->tradeexpert->getClientPager(1, 4, $c, TradeExpertClientPeer::TEC_STAT_APPROVED)->getResults();

        RatingPeer::logNewVisit($this->tradeexpert->getId(), PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT);
    }
    
    public function handleError()
    {
    }
    
}