<?php

class PlaceTypePeer extends BasePlaceTypePeer
{
    CONST PLC_TYP_CONGRESS_CENTER   = 1;
    CONST PLC_TYP_EXHIBITION_CENTER = 2;
    CONST PLC_TYP_SPORTS_ARENA      = 3;
    
    public static $bussTypes = array(self::PLC_TYP_CONGRESS_CENTER,
                                     self::PLC_TYP_EXHIBITION_CENTER
                                    );
    
    public static $sporTypes = array(self::PLC_TYP_SPORTS_ARENA,
                                    );
    
    public static function getOrderedNames($types = null)
    {
        $c = new Criteria();
        if (isset($types)) $c->add(PlaceTypePeer::ID, $types, Criteria::IN);
        
        $c->addAscendingOrderByColumn(myTools::NLSFunc(PlaceTypeI18nPeer::NAME, 'SORT'));
        return PlaceTypePeer::doSelectWithI18n($c);
    }

}
