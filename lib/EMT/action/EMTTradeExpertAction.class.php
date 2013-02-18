<?php

class EmtTradeExpertAction extends EmtAction
{

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->tradeexpert = TradeExpertPeer::getTradeExpertFromUrl($this->getRequest()->getParameterHolder());
        
        $this->forward404Unless($this->tradeexpert);

        $this->getResponse()->addMeta('description', myTools::trim_text($this->tradeexpert->getClob(TradeExpertI18nPeer::INTRODUCTION, 250), true));

    }
    
}
