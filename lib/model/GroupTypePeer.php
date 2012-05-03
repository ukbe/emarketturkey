<?php

class GroupTypePeer extends BaseGroupTypePeer
{
    CONST GRTYP_ONLINE              = 8;
    
    public static function getOrderedNames($for_select = false)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(GroupTypeI18nPeer::NAME);
        
        if ($for_select)
        {
            $cats = GroupTypePeer::doSelectWithI18n($c);
            $catys = array();
            foreach ($cats as $cat){
                $catys[$cat->getId()] = $cat->getName();
            }
            return $catys;
        }
        
        return GroupTypePeer::doSelectWithI18n($c);
    }
}
