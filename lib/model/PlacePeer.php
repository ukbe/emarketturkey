<?php

class PlacePeer extends BasePlacePeer
{
    public static function getFeaturedPlaces($num = null, $types = null)
    {
        $typearr = (!is_array($types) ? array($types) : $types);

        $con = Propel::getConnection();

        $sql = "
            SELECT DISTINCT * FROM (
                SELECT EMT_PLACE.* FROM EMT_PLACE
                LEFT JOIN EMT_PLACE_I18N ON EMT_PLACE.ID=EMT_PLACE_I18N.ID
                WHERE EMT_PLACE.TYPE_ID IN (".implode(', ', $typearr).")
                    AND EMT_PLACE.IS_FEATURED=1
                ORDER BY ".myTools::NLSFunc(PlaceI18nPeer::NAME, 'SORT')."
            )
            ".(isset($num) ? " WHERE ROWNUM <= $num" : "")." 
        ";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return self::populateObjects($stmt);
    }

    public static function getPlaceFromUrl(sfParameterHolder $ph)
    {
        $app = sfContext::getInstance()->getConfiguration()->getApplication();
        $c = new Criteria();

        $id = myTools::flipHash($ph->get('hash'), true, PrivacyNodeTypePeer::PR_NTYP_PLACE);

        if (!preg_match("/^\d+$/", $id)) return null;
        $c->add(PlacePeer::ID, $id);
        
        return self::doSelectOne($c);
    }
    
}