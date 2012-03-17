<?php

class ConsentLogin extends BaseConsentLogin
{
    public function getTokenContent()
    {
        $conf = Propel::getConfiguration();
        $conf = $conf['datasources'][$conf['datasources']['default']]['connection'];
        
        if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
        if (!($c = @oci_connect($conf['user'], $conf['password'], $conf['database'])))
        {return "no connection";}
        
        $sql = "SELECT TOKEN 
                FROM EMT_CONSENT_LOGIN 
                WHERE ID={$this->getId()}";
        $stmt = oci_parse($c, $sql);
        oci_execute($stmt);
        $res = oci_fetch_assoc($stmt);
        return $res ? $res['TOKEN']->load() : "";
    }
}
