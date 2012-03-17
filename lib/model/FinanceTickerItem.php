<?php

class FinanceTickerItem extends BaseFinanceTickerItem
{
    public function addData($values)
    {
        // values = lastprice, change, changepercent
        $item = new FinanceTickerData();
        $item->setItemId($this->getId());
        $item->setData($values['lastprice']);
        $item->setChange($values['change']);
        $item->setChangePercent($values['changepercent']);
        $item->save();
    }
}
