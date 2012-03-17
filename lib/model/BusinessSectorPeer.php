<?php

class BusinessSectorPeer extends BaseBusinessSectorPeer
{
    public static function getOrderedNames($for_select = false)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(myTools::NLSFunc(BusinessSectorI18nPeer::NAME, 'SORT'));
        
        if ($for_select)
        {
            $cats = BusinessSectorPeer::doSelectWithI18n($c);
            $catys = array();
            foreach ($cats as $cat){
                $catys[$cat->getId()] = $cat->getName();
            }
            return $catys;
        }
        
        return BusinessSectorPeer::doSelectWithI18n($c);
    }

    public static function retrieveByStrippedName($name)
    {
        $c = new Criteria();
        $c->add(BusinessSectorI18nPeer::STRIPPED_NAME, $name);
        $inds = self::doSelectWithI18n($c);
        if (is_array($inds) && count($inds))
        {
            return $inds[0];
        }
        else
        {
            return null;
        }
    }
}
