<?php

class GeonameCity extends BaseGeonameCity
{
    public function __toString()
    {
        return $this->getName(); 
    }
    
    public function getParent()
    {
        $c = new Criteria();
        $c->addJoin(GeonameHierarchyPeer::PARENT_ID, GeonameCityPeer::GEONAME_ID, Criteria::LEFT_JOIN);
        $c->add(GeonameHierarchyPeer::CHILD_ID, $this->getGeonameId());
        $parents = GeonameCityPeer::doSelect($c);
        return count($parents)?$parents[0]:null;
    }
    
}
