<?php

class LocationUpdate extends BaseLocationUpdate
{
    public function __toString()
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Asset', 'I18N'));
        return implode(',', array_filter(array($this->getGeonameCityRelatedByCity(), 
                                               $this->getGeonameCityRelatedByState()?$this->getGeonameCityRelatedByState()->getAdmin1Code():null
                                               )
                                         )
                       ) . image_tag('/images/layout/flag/'.$this->getCountry().'.png', array('title' => format_country($this->getCountry()))); 
    }
    
    public function getOwner()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getObjectId(), $this->getObjectTypeId());
    }

    public function getUrl()
    {
        return $this->getOwner()->getProfileUrl();
    }

    public function getDefineText($to_user, $culture)
    {
        $top_owner = PrivacyNodeTypePeer::getTopOwnerOf($this);
        $is_owner = (($top_owner && $to_user->getId() == $top_owner->getId()) ? true : false);
        $owner = $this->getOwner();

        $i18n = sfContext::getInstance()->getI18N();
        $cl = $i18n->getCulture();
        $i18n->setCulture($culture);

        $result = $is_owner ? $i18n->__("your location update") : $i18n->__("%1u's location update", array('%1u' => $owner));

        $i18n->setCulture($cl);
        return $result;
    }
}
