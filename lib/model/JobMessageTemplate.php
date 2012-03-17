<?php

class JobMessageTemplate extends BaseJobMessageTemplate
{
    
    public function getEditUrl()
    {
       return ($this->getHrProfileId() ? (sfContext::getInstance()->getConfiguration()->getApplication() == 'myemt' ? "@" : "@myemt.") . ($this->getHrProfile()->getOwnerTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? "company-jobs-action?action=messageTemplate&hash={$this->getHrProfile()->getOwner()->getHash()}&id={$this->getId()}" : "group-jobs-action?action=messageTemplate&hash={$this->getHrProfile()->getOwner()->getHash()}&id={$this->getId()}") : null);  
    }

    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentJobMessageTemplateI18n($culture);
        return $lsi->isNew()?false:true;
    }
    
    public function getExistingI18ns()
    {
        if ($this->isNew())
        {
            return array();
        }
        else
        {
            $con = Propel::getConnection();
            
            $sql = "SELECT CULTURE FROM EMT_JOB_MESSAGE_TEMPLATE_I18N 
                    WHERE ID={$this->getId()}";
    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
    }
    
    public function removeI18n($culture)
    {
        $c = new Criteria();
        $c->add(JobMessageTemplateI18nPeer::ID, $this->getId());
        $c->add(JobMessageTemplateI18nPeer::CULTURE, $culture, is_array($culture) ? Criteria::IN : Criteria::EQUAL);
        return JobMessageTemplateI18nPeer::doDelete($c);
    }
    
    public function getClob($field, $culture = null)
    {
        if ($this->isNew()) return null;
        $conf = Propel::getConfiguration();
        $conf = $conf['datasources'][$conf['datasources']['default']]['connection'];
        
        if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
        if (!($c = @oci_connect($conf['user'], $conf['password'], $conf['database'])))
        {echo "no connection";}
        
        $sql = "SELECT $field 
                FROM EMT_JOB_MESSAGE_TEMPLATE_I18N 
                WHERE ID={$this->getId()} AND CULTURE='$culture'";
        $stmt = oci_parse($c, $sql);
        oci_execute($stmt);
        $res = oci_fetch_row($stmt);
        return isset($res[0]) ? $res[0]->load() : "";
    }
    
}
