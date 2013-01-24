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

    public static function retrieveByStrippedName($name, $ignore_culture = false)
    {
        $c = new Criteria();
        $c->add(BusinessSectorI18nPeer::STRIPPED_NAME, $name);
        if ($ignore_culture)
        {
            $sects = BusinessSectorI18nPeer::doSelect($c);
        }
        else
        {
            $sects = self::doSelectWithI18n($c);
        }
        if (is_array($sects) && count($sects))
        {
            return $ignore_culture ? $sects[0]->getBusinessSector() : $sects[0];
        }
        else
        {
            return null;
        }
    }
}
