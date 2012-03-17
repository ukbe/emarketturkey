<?php

class checkoutAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->cart = $this->sesuser->getCart();

        $totals = array();

        foreach ($this->cart as $custyp => $custs)
        {
            foreach ($custs as $cusid => $items)
            {
                foreach ($items as $item)
                {
                    $pack = MarketingPackagePeer::validatePackageFor($item, $custyp);
                    $price = $pack->getPriceFor($custyp);
                    if ($price)
                    {
                        if (!isset($totals[$price->getCurrency()])) $totals[$price->getCurrency()] = 0;
                        $totals[$price->getCurrency()] += $price->getPrice();
                    }
                    else
                    {
                        $priceError = true;
                    }
                }
            }
        }
        $this->totals = $totals;
    }

    public function handleError()
    {
    }
    
}