<?php

class locationQueryAction extends EmtAction
{
    public function execute($request)
    {
        $cc = $this->getRequestParameter('cc');
        $lc = $this->getRequestParameter('lc')==1;
        $nb = $this->getRequestParameter('nb')==1;
        
        if (!preg_match("/^[A-Z]{2}$/", $cc)) return $this->renderText(json_encode(array()));

        $con = Propel::getConnection();
        $sql = "SELECT ".($lc ? "EXT_GEONAME_COUNTRY.ISO||'-'||EXT_GEONAME.ADMIN1_CODE RC" : "EXT_GEONAME.GEONAME_ID ID").", ".($lc ? "EXT_GEONAME.NAME RN" : "EXT_GEONAME.NAME NAME")." FROM EXT_GEONAME_HIERARCHY
                LEFT JOIN EXT_GEONAME ON EXT_GEONAME_HIERARCHY.CHILD_ID=EXT_GEONAME.GEONAME_ID
                LEFT JOIN EXT_GEONAME_COUNTRY ON EXT_GEONAME_HIERARCHY.PARENT_ID=EXT_GEONAME_COUNTRY.GEONAME_ID
                WHERE (EXT_GEONAME_HIERARCHY.TYPE='ADM') AND (EXT_GEONAME.FEATURE_CODE='ADM1' OR EXT_GEONAME.FEATURE_CODE='ADM2') AND EXT_GEONAME_COUNTRY.ISO='$cc'
                ORDER BY NLSSORT(NAME,'NLS_SORT=GENERIC_M_CI') 
               ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($nb)
        {
            sfLoader::loadHelpers(array('I18N'));
            $cnt = GeonameCountryPeer::retrieveByISO($cc);
            foreach (explode(',', $cnt->getNeighbours()) as $nb)
            {
                $neighbours[] = array('CC' => $nb, 'CN' => format_country($nb));
            }
        }
        
        return $this->renderText(json_encode(isset($neighbours) ? array('neighbours' => $neighbours, 'cities' => $cities) : $cities ));
    }
}