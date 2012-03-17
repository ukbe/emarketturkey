<?php

class RelationUpdate extends BaseRelationUpdate
{
    public function __toString()
    {
        return $this->getRole()->__toString(); 
    }

    public function getSubject()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getSubjectId(), $this->getSubjectTypeId());
    }

    public function getObject()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getObjectId(), $this->getObjectTypeId());
    }
    
    public function getOwner()
    {
        return $this->getSubject();
    }

    public function getDefineText($to_user, $culture)
    {
        $object = $this->getObject();
        $object_top = PrivacyNodeTypePeer::getTopOwnerOf($object);
        $subject = $this->getSubject();
        $subject_top = PrivacyNodeTypePeer::getTopOwnerOf($subject);
        
        $is_subject = ($subject_top->getId() == $to_user->getId()); 
        $is_object = ($object_top->getId() == $to_user->getId());
         
        $is_related = ($is_subject || $is_object);
        
        $i18n = sfContext::getInstance()->getI18N();
        $cl = $i18n->getCulture();
        $i18n->setCulture($culture);

        $result = $i18n->__("relation status");
        
        if (($is_object && $this->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_USER)
              || ($is_subject && $this->getSubjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_USER))
        {
            $result = $i18n->__("relation status update between you and %1x", array('%1x' => $is_subject ? $object : $object));
        }
        else
        {
            $result = $i18n->__("relation status update between %1x and %2x", array('%1x' => $object, '%2x' => $subject));
        }

        $i18n->setCulture($cl);
        return $result;
    }
    
    public function getUrl()
    {
        return $this->getOwner()->getProfileUrl();
    }
}
