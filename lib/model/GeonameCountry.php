<?php

class GeonameCountry extends BaseGeonameCountry
{
    
    public function getLocatedInString()
    {
        $country = sfContext::getInstance()->getI18N()->getCountry($this->getIso());
        if (sfContext::getInstance()->getUser()->getCulture() == 'tr')
        {
        $ctemp = strrev(strtr($country, array('I' => 'A', 'O' => 'A', 'U' => 'A', 'a' => 'A', 'ı' => 'A', 'o' => 'A', 'u' => 'A',
                                           'İ' => 'E', 'Ö' => 'E', 'Ü' => 'E', 'e' => 'E', 'i' => 'E', 'ö' => 'E', 'ü' => 'E')));
            $ax = strpos($ctemp, 'A');
            $ex = strpos($ctemp, 'E');
            $ax = $ax===false ? 9999 : $ax;
            $ex = $ex===false ? 9999 : $ex;
            $country .= "'";
            $country .= (count(explode(' ', $country)) > 1 && ($ax === 0 || $ex === 0) ? 'n' : '');
            if ($ax < $ex)
            {
                $country .= 'daki';
            }
            else
            {
                $country .= 'deki';
            }
        } 

        return $country;
    }
    
    public function getStates()
    {
        $con = Propel::getConnection();
        $sql = "select * from (
                    select ext_geoname.*, parentt.name pname from ext_geoname_hierarchy
                    inner join ext_geoname on ext_geoname_hierarchy.child_id=ext_geoname.geoname_id
                    left join ext_geoname parentt on ext_geoname_hierarchy.parent_id=parentt.geoname_id
                    where (ext_geoname_hierarchy.type='ADM') and (ext_geoname.feature_code='ADM1' or ext_geoname.feature_code='ADM2') and (NLS_LOWER(ext_geoname.name) like NLS_LOWER('%$typ%') or NLS_LOWER(parentt.name) like NLS_LOWER('%$typ%')) 
                )";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        $this->cities = array();
        while ($city = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            //$ct = new GeonameCity();
            //$ct->fromArray($city);
            $this->cities[] = array('id' => $city['GEONAME_ID'], 'label' => $city['NAME'].', '.$city['PNAME']); 
        }
        $c = new Criteria();
        $c->addJoin(GeonameCityPeer::GEONAME_ID, GeonameHierarchyPeer::PARENT_ID);
        $c->addJoin(GeonameHierarchyPeer::PARENT_ID, GeonameCountryPeer::GEONAME_ID);
        $c->add(GeonameCountryPeer::ISO, $this->getIso());
        return GeonameCityPeer::doSelect($c);
    }
}
