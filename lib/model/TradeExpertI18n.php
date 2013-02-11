<?php

class TradeExpertI18n extends BaseTradeExpertI18n
{
    public function setName($name)
    {
        parent::setName($name);
        
        $this->setStrippedName(myTools::url_slug($name));
    }
}
