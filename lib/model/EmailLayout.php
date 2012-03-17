<?php

class EmailLayout extends BaseEmailLayout
{
    public function getClob($field, $culture = null)
    {
        $conf = Propel::getConfiguration();
        $conf = $conf['datasources'][$conf['datasources']['default']]['connection'];
        
        if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
        if (!($c = @oci_connect($conf['user'], $conf['password'], $conf['database'])))
        {echo "no connection";}
        
        $sql = "SELECT $field 
                FROM EMT_EMAIL_LAYOUT_I18N 
                WHERE ID={$this->getId()} AND CULTURE='$culture'";
        $stmt = oci_parse($c, $sql);
        oci_execute($stmt);
        $res = oci_fetch_row($stmt);
        return isset($res[0]) ? $res[0]->load() : "";
    }
    
}
