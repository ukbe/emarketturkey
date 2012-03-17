<?php

class Announcement extends BaseAnnouncement
{
    public function getContentForRecipient($recipient_id, $recipient_type_id = null)
    {
        $lay = $this->getEmailLayout();
        $vars = unserialize($lay->getClob(EmailLayoutI18nPeer::DEFAULTS));
        $rec = $this->getRecipient($recipient_id, $recipient_type_id);
        
        sfLoader::loadHelpers('url');
        
        $title = $this->getDisplayTitle() ? $this->getDisplayTitle() : $lay->getDisplayTitle();
        $content = $lay->getClob(EmailLayoutI18nPeer::CONTENT);
        $dynvals = array('{sname}' => $this->getOwner()->__toString(),
                         '{oname}' => $rec->__toString(),
                         '{sprofilelink}' => link_to($this->getOwner()->__toString(), $this->getOwner()->getProfileUrl()),
                         '{culture}' => sfContext::getInstance()->getUser()->getCulture()
            );
        
        $vars = array_merge($vars, unserialize($this->getClob(AnnouncementI18nPeer::DATA)), $dynvals);
        return strtr($content, $vars);
        
    }
    
    public function getOwner()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getOwnerId(), $this->getOwnerTypeId());
    }
    
    public function getRecipient($recipient_id, $recipient_type_id = null)
    {
        $c = new Criteria();
        
        if (isset($recipient_type_id))
        {
            $c->add(AnnRecipientPeer::RECIPIENT_ID, $recipient_id);
            $c->add(AnnRecipientPeer::RECIPIENT_TYPE_ID, $recipient_type_id);
        }
        else
        {
            $c->add(AnnRecipientPeer::ID, $recipient_id);
        }
        
        $recis = $this->getAnnRecipients();
        return count($recis) ? (isset($recipient_type_id) ? $recis[0]->getObject() : $recis[0]) : null;
    }
    
    public function getClob($field, $culture = null)
    {
        $conf = Propel::getConfiguration();
        $conf = $conf['datasources'][$conf['datasources']['default']]['connection'];
        
        if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
        if (!($c = @oci_connect($conf['user'], $conf['password'], $conf['database'])))
        {echo "no connection";}
        
        $sql = "SELECT $field 
                FROM EMT_ANNOUNCEMENT_I18N 
                WHERE ID={$this->getId()} AND CULTURE='$culture'";
        $stmt = oci_parse($c, $sql);
        oci_execute($stmt);
        $res = oci_fetch_row($stmt);
        return isset($res[0]) ? $res[0]->load() : "";
    }
    
}
