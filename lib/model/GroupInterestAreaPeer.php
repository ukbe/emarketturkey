<?php

class GroupInterestAreaPeer extends BaseGroupInterestAreaPeer
{
    public static function getOrderedNames()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(GroupInterestAreaI18nPeer::NAME);
        return GroupInterestAreaPeer::doSelectWithI18n($c);
    }
}
