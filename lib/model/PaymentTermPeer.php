<?php

class PaymentTermPeer extends BasePaymentTermPeer
{
    public static function getOrderedPaymentTerms()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(PaymentTermI18nPeer::NAME);
        return self::doSelectWithI18n($c);
    }
}
