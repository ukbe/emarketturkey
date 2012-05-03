<?php

class PremiumAccount extends BasePremiumAccount
{
    public function getBadgeUri($size = 'medium')
    {
        return PremiumAccountPeer::$icons[$this->getAccountTypeId()][$size];
    }
}
