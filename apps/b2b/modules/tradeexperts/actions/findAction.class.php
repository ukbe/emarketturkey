<?php

class findAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.tradeexperts-action?".http_build_query($params), 301);

        $this->featured_tradeexperts = TradeExpertPeer::getFeaturedTradeExperts(20);
        $exps = $this->sesuser->getConnections(null, null, false, true, null, false, 5, 1, null, PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT);
        $this->net_tradeexperts = $exps->getResults();
    }
    
    public function handleError()
    {
    }
    
}
