<?php

class TimePeriodPeer extends BaseTimePeriodPeer
{
    public static function getOrderedPeriods($for_select = false, $culture = null)
    {
        $c = new Criteria();
        if (isset($culture)) $c->add(TimePeriodI18nPeer::CULTURE, $culture);
        //$c->addAscendingOrderByColumn(TimePeriodI18nPeer::LABEL);
        $units = self::doSelectWithI18n($c);
        
        if ($for_select) {
            $uns = array();
            foreach ($units as $unit) {
                $uns[$unit->getId()] = $unit->getLabel();
            }
            return $uns;
        }
        else {
            return $units;
        }
    }
}
