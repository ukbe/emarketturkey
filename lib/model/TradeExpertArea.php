<?php

class TradeExpertArea extends BaseTradeExpertArea
{
    public function __toString()
    {
        sfLoader::loadHelpers('I18N');
        return format_country($this->getCountry()); 
    }
    
}
