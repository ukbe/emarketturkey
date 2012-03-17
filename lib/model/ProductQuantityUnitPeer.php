<?php

class ProductQuantityUnitPeer extends BaseProductQuantityUnitPeer
{
    public static function getOrderedQuantities($for_select = false, $culture = null)
    {
        $c = new Criteria();
        if (isset($culture)) $c->add(ProductQuantityUnitI18nPeer::CULTURE, $culture);
        $c->addAscendingOrderByColumn(ProductQuantityUnitI18nPeer::NAME);
        $units = self::doSelectWithI18n($c);
        
        if ($for_select) {
            $uns = array();
            foreach ($units as $unit) {
                $uns[$unit->getId()] = $unit->getName();
            }
            return $uns;
        }
        else {
            return $units;
        }
    }
}
