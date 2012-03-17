<?php

class CompanyUser extends BaseCompanyUser
{
    private $aobject = null;
    
    public function getObject()
    {
        if ($this->getObjectId() !== null && $this->getObjectTypeId() !== null && $this->aobject === null)
        {
            $this->aobject = PrivacyNodeTypePeer::retrieveObject($this->getObjectId(), $this->getObjectTypeId());
        }
        return $this->aobject;
    }
}
