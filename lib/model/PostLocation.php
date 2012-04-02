<?php

class PostLocation extends BasePostLocation
{
    private $hash = null;
        
    public function __toString()
    {
        return implode(', ', array_filter(array($this->getCity(), $this->getCountry())));
    }

    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_POST_LOCATION;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_POST_LOCATION) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getUrl()
    {
        return "@homepage";
    }

    public function save(PropelPDO $con = null)
    {
        $con = isset($con) ? $con : Propel::getConnection();
        try
        {
            $con->beginTransaction();
            $clobs = array();
            $clobs['data'] = $this->getData();

            $this->setData(null);

            $res = parent::save($con);
    
            $sql = "UPDATE EMT_POST_LOCATION 
                    SET data=:data
                    WHERE id=".$this->getId();
    
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':data', $clobs['data'], PDO::PARAM_STR, strlen($clobs['data']));
            $stmt->execute();
            $con->commit();
        }
        catch(Exception $e)
        {
            $con->rollBack();
            return null;
        }
        return $res;
    }

    public function getClob($field, $culture = null)
    {
        $conf = Propel::getConfiguration();
        $conf = $conf['datasources'][$conf['datasources']['default']]['connection'];
        
        if (!$culture) $culture = sfContext::getInstance()->getUser()->getCulture();
        if (!($c = @oci_connect($conf['user'], $conf['password'], $conf['database'])))
        {echo "no connection";}
        
        $sql = "SELECT $field 
                FROM EMT_POST_LOCATION 
                WHERE ID={$this->getId()} AND CULTURE='$culture'";
        $stmt = oci_parse($c, $sql);
        oci_execute($stmt);
        $res = oci_fetch_row($stmt);
        return isset($res[0]) ? $res[0]->load() : "";
    }
    
}
