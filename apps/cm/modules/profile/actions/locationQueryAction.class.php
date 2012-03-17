<?php

class locationQueryAction extends EmtAction
{
    public function execute($request)
    {
        //$this->cc = substr($this->getRequestParameter('country_code', '##'), 0, 2);
        $typ = str_replace("'", '', $this->getRequestParameter('term'));
        $typ = str_replace('"', '', $typ);

        $con = Propel::getConnection();
        $sql = "select * from (
                    select ext_geoname.*, parentt.name pname from ext_geoname_hierarchy
                    inner join ext_geoname on ext_geoname_hierarchy.child_id=ext_geoname.geoname_id
                    left join ext_geoname parentt on ext_geoname_hierarchy.parent_id=parentt.geoname_id
                    where (ext_geoname_hierarchy.type='ADM') and (ext_geoname.feature_code='ADM1' or ext_geoname.feature_code='ADM2') and (NLS_LOWER(ext_geoname.name) like NLS_LOWER('%$typ%') or NLS_LOWER(parentt.name) like NLS_LOWER('%$typ%')) 
                )
                where ROWNUM<15";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        $this->cities = array();
        while ($city = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            //$ct = new GeonameCity();
            //$ct->fromArray($city);
            $this->cities[] = array('id' => $city['GEONAME_ID'], 'label' => $city['NAME'].', '.$city['PNAME']); 
        }
        return $this->renderText(json_encode($this->cities));
    }
}