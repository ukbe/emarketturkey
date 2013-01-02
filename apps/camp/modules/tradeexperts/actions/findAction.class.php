<?php

class findAction extends EmtAction
{
    public function execute($request)
    {
        $this->featured_tradeexperts = TradeExpertPeer::getFeaturedTradeExperts(20);
        $exps = $this->sesuser->getConnections(null, null, false, true, null, false, 5, 1, null, PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT);
        $this->net_tradeexperts = $exps->getResults();
    }
    
    public function handleError()
    {
    }
    
}
