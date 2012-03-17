<?php

class StatusUpdate extends BaseStatusUpdate
{
    public function __toString()
    {
        return $this->getMessage() ? $this->getMessage() : ''; 
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
        $is_owner = ($top_owner && $to_user->getId() == $top_owner->getId()) ? true : false;
        $owner = $this->getOwner();

        $i18n = sfContext::getInstance()->getI18N();
        $cl = $i18n->getCulture();
        $i18n->setCulture($culture);

        $result = "a status update";
        
        switch ($this->getObjectTypeId())
        {
            case PrivacyNodeTypePeer::PR_NTYP_USER :
                $result = $is_owner ? $i18n->__("your status message") : $i18n->__("%1u's status message", array('%1u' => $owner));
                break;
            case PrivacyNodeTypePeer::PR_NTYP_GROUP :
                $result = $is_owner ? $i18n->__("status message of your group %1g", array('%1g' => $owner)) : $i18n->__("status message of group %1g", array('%1g' => $owner));
                break;
        }
        $i18n->setCulture($cl);
        return $result;
    }
    
}
