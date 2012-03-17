<?php

class GroupTypePeer extends BaseGroupTypePeer
{
    CONST GRTYP_ONLINE              = 8;
    
    public static function getOrderedNames()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(GroupTypeI18nPeer::NAME);
        return GroupTypePeer::doSelectWithI18n($c);
    }
}
