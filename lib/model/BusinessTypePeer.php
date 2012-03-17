<?php

class BusinessTypePeer extends BaseBusinessTypePeer
{
    CONST BTYP_MANUFACTURER       = 1;
    CONST BTYP_RETAIL             = 2;
    CONST BTYP_AGENT              = 3;
    CONST BTYP_DISTRIBUTOR        = 4;
    
    public static $typeNames    = array (1 => 'Manufacturer',
                                         2 => 'Retail',
                                         3 => 'Agent',
                                         4 => 'Distributor'
                                        );
    
    public static function getOrderedNames($for_select = false)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(BusinessTypeI18nPeer::NAME);
        
        if ($for_select)
        {
            $cats = BusinessTypePeer::doSelectWithI18n($c);
            $catys = array();
            foreach ($cats as $cat){
                $catys[$cat->getId()] = $cat->getName();
            }
            return $catys;
        }
        
        return BusinessTypePeer::doSelectWithI18n($c);
    }
}