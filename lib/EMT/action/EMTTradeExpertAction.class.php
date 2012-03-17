<?php

class EmtTradeExpertAction extends EmtAction
{

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->tradeexpert = TradeExpertPeer::getTradeExpertFromUrl($this->getRequest()->getParameterHolder());
        
        $this->forward404Unless($this->tradeexpert);

    }
    
}
