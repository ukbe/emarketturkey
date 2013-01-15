<?php

class EmtTradeExpertAction extends EmtAction
{

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->tradeexpert = TradeExpertPeer::getTradeExpertFromUrl($this->getRequest()->getParameterHolder());
        
        $this->getResponse()->addMeta('description', $this->tradeexpert->getIntroduction());

        $this->forward404Unless($this->tradeexpert);

    }
    
}
