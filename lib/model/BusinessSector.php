<?php

class BusinessSector extends BaseBusinessSector
{
    public function __toString()
    {
        return $this->getName()!=''?$this->getName():$this->getName('en'); 
    }
    
    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentBusinessSectorI18n($culture);
        return $lsi->isNew()?false:true;
    }
    
    public function countJobApplications($country_code=null, $state_id=null)
    {
        return 0;
        $c = new Criteria();
        $c->add(JobPeer::STATUS, JobPeer::JSTYP_ONLINE);
        if ($country_code){
            $c->addJoin(JobPeer::LOCATION_ID, GeonameCityPeer::GEONAME_ID, Criteria::INNER_JOIN);
            $c->addJoin(GeonameCityPeer::GEONAME_ID, GeonameHierarchyPeer::CHILD_ID, Criteria::INNER_JOIN);
            $c->addJoin(GeonameHierarchyPeer::PARENT_ID, GeonameCountryPeer::GEONAME_ID, Criteria::INNER_JOIN);
            $c->add(GeonameCountryPeer::ISO, $country_code);
        }
        if ($state_id) $c->add(JobPeer::LOCATION_ID, $state_id);
        
        return $this->countJobs($c);
    }
}
