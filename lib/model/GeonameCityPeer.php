<?php

class GeonameCityPeer extends BaseGeonameCityPeer
{
    public static function getCitiesFor($country_code, $limit=null)
    {
        $con = Propel::getConnection();
        
        $sql = "SELECT EXT_GEONAME.GEONAME_ID, EXT_GEONAME.NAME 
                FROM EXT_GEONAME
                LEFT JOIN EXT_GEONAME_HIERARCHY ON EXT_GEONAME.GEONAME_ID=EXT_GEONAME_HIERARCHY.CHILD_ID
                LEFT JOIN EXT_GEONAME_COUNTRY ON EXT_GEONAME_HIERARCHY.PARENT_ID=EXT_GEONAME_COUNTRY.GEONAME_ID
                WHERE EXT_GEONAME_COUNTRY.ISO='$country_code' 
                ORDER BY NLSSORT(NAME,'NLS_SORT=GENERIC_M_CI')";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $rs = array();
        while ($row = $stmt->fetch(PDO::FETCH_NUM))
        {
            $rs[$row[0]] = $row[1];
        }
        return $rs;
    }
}
