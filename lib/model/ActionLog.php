<?php

class ActionLog extends BaseActionLog
{
    private $issuer = null;
    private $target = null;
    private $object = null;
    
    public function toString()
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));
        $sentence =$this->getActionCase()->getLogSentence();
        return strtr($sentence, array('%i.a'    => strpos($sentence, '%i.a')!==null ? PrivacyNodeTypePeer::objectHasAdjective($this->getIssuer()) ? $this->getIssuer()->getAdjective() : null : null,
                                      '%t.a'    => strpos($sentence, '%t.a')!==null ? $this->getTarget() && PrivacyNodeTypePeer::objectHasAdjective($this->getTarget()) ? $this->getTarget()->getAdjective() : null : null,
                                      '%o.a'    => strpos($sentence, '%o.a')!==null ? $this->getObject() && PrivacyNodeTypePeer::objectHasAdjective($this->getObject()) ? $this->getObject()->getAdjective() : null : null,
                                      '%i'      => strpos($sentence, '%i')!==null ? link_to($this->getIssuer(), $this->getIssuer()->getProfileUrl()) : null,
                                      '%t'      => strpos($sentence, '%t')!==null ? ($this->getTarget() ? link_to($this->getTarget(), $this->getTarget()->getProfileUrl()) : null) : null,
                                      '%o'      => strpos($sentence, '%o')!==null ? ($this->getObject() ? (($obj_link = PrivacyNodeTypePeer::getObjectUrl($this->getObject())) ? link_to($this->getObject(), $obj_link) : $this->getObject()) : null) : null
                                )
                    );
    }

    public function getIssuer()
    {
        if ($this->getIssuerId() !== null && $this->issuer === null)
        {
            $this->issuer = PrivacyNodeTypePeer::retrieveObject($this->getIssuerId(), $this->getActionCase()->getIssuerTypeId());
        }
        return $this->issuer;
    }
    
    public function getTarget()
    {
        if ($this->getTargetId() !== null && $this->target === null)
        {
            $this->target = PrivacyNodeTypePeer::retrieveObject($this->getTargetId(), $this->getActionCase()->getTargetTypeId());
        }
        return $this->target;
    }

    public function getObject()
    {
        if ($this->getObjectId() !== null && $this->getObjectTypeId() !== null && $this->object === null)
        {
            $this->object = PrivacyNodeTypePeer::retrieveObject($this->getObjectId(), $this->getObjectTypeId());
        }
        return $this->object;
    }
    
    public function getOwner()
    {
        return $this->getIssuer();
    }
    
    public function getUrl()
    {
        $app = sfContext::getInstance()->getConfiguration()->getApplication();
        return $app == 'cm' ? '@network-activity' : '@cm.network-activity';
    }
    
    public function getDefineText($to_user, $culture)
    {
        $top_owner = PrivacyNodeTypePeer::getTopOwnerOf($this);
        $is_owner = ($top_owner && $to_user->getId() == $top_owner->getId()) ? true : false;
        $owner = $this->getOwner();
        
        $i18n = sfContext::getInstance()->getI18N();
        $cl = $i18n->getCulture();
        $i18n->setCulture($culture);
        
        switch ($this->getActionCase()->getActionId())
        {
            case ActionPeer::ACT_POST_WALL : return ""; //@todo: prepare this text when wall is implemented
            case ActionPeer::ACT_FOLLOW_COMPANY : return $is_owner ? $i18n->__("your following of company %1c", array('%1c' => $this->getTarget())) : __("%1u's following of company %2c", array('%1u' => $owner, '%2c' => $this->getTarget()));
            case ActionPeer::ACT_JOIN_GROUP : return $is_owner ? $i18n->__("your membership to %1g", array('%1g' => $this->getTarget())) : __("%1u's membership to %2g", array('%1u' => $owner, '%2g' => $this->getTarget()));
            case ActionPeer::ACT_UPLOAD_PROFILE_PICTURE : return $is_owner ? $i18n->__("your new profile picture %1p", array('%1p' => $this->getObject())) : __("%1u's new profile picture %2p", array('%1u' => $owner, '%2p' => $this->getObject()));
            case ActionPeer::ACT_UPLOAD_LOGO :
                $owner_type = PrivacyNodeTypePeer::getTypeFromClassname($owner);
                if ($owner_type == PrivacyNodeTypePeer::PR_NTYP_COMPANY)
                { 
                    return $is_owner ? $i18n->__("new logo of your company %1c", array('%1c' => $owner)) : __("%1c's new logo", array('%1c' => $owner));
                }
                elseif ($owner_type == PrivacyNodeTypePeer::PR_NTYP_GROUP)
                {
                    return $is_owner ? $i18n->__("new logo of your group %1g", array('%1g' => $owner)) : __("%1g's new logo", array('%1g' => $owner));
                }
            case ActionPeer::ACT_UPLOAD_HR_LOGO : return $is_owner ? $i18n->__("new human resources logo of your company %1c", array('%1c' => $owner)) : __("%1c's new human resources logo", array('%1c' => $owner));
            case ActionPeer::ACT_ACCEPT_FRIENDSHIP_REQUEST : 
                $is_subject = ($this->getIssuerId() == $to_user->getId()); 
                $is_object = ($this->getTargetId() == $to_user->getId());
                $is_related = ($is_subject || $is_object);
                return $is_related ? $i18n->__("your friendship with %1x", array('%1x' => $is_subject ? $this->getTarget() : $this->getIssuer())) : __("friendship between %1i and %2t", array('%1i' => $this->getIssuer(), '%2t' => $this->getTarget()));
        }
        return "#unidentified item#";
    }
}
