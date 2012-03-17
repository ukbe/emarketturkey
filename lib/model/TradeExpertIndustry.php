<?php

class TradeExpertIndustry extends BaseTradeExpertIndustry
{
    public function __toString()
    {
        return $this->getBusinessSector(); 
    }
}
