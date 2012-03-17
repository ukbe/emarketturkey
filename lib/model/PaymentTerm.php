<?php

class PaymentTerm extends BasePaymentTerm
{
    public function __toString()
    {
        return $this->getCode().' - '.$this->getName(); 
    }

    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentPaymentTermI18n($culture);
        return $lsi->isNew()?false:true;
    }
}
