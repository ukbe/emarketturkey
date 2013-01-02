<?php

class connectedAction extends EmtAction
{
    public function execute($request)
    {
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->industry = is_numeric($this->getRequestParameter('industry')) ? BusinessSectorPeer::retrieveByPK($this->getRequestParameter('industry')) : null;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('country')) : '';
        
        $joins = $wheres = array();
        
        if ($this->keyword || $this->country)
        {
            $joins[] = "LEFT JOIN EMT_COMPANY_PROFILE ON EMT_COMPANY.PROFILE_ID=EMT_COMPANY_PROFILE.ID";
            $joins[] = "LEFT JOIN EMT_CONTACT ON EMT_COMPANY_PROFILE.CONTACT_ID=EMT_CONTACT.ID";
            $joins[] = "LEFT JOIN EMT_CONTACT_ADDRESS ON EMT_CONTACT.ID=EMT_CONTACT_ADDRESS.CONTACT_ID";
        }
        
        if ($this->keyword)
        {
            $joins[] = "LEFT JOIN EMT_COMPANY_PROFILE_I18N ON EMT_COMPANY_PROFILE.ID=EMT_COMPANY_PROFILE_I18N.ID";
            $joins[] = "LEFT JOIN EXT_GEONAME_COUNTRY ON EMT_CONTACT_ADDRESS.COUNTRY=EXT_GEONAME_COUNTRY.COUNTRY";
            
            $wheres[] = "
                (
                    UPPER(EMT_COMPANY_PROFILE.CERTIFICATIONS) LIKE UPPER('%{$this->keyword}%')
                 OR UPPER(EMT_COMPANY_PROFILE_I18N.INTRODUCTION) LIKE UPPER('%{$this->keyword}%')
                 OR UPPER(EMT_COMPANY_PROFILE_I18N.PRODUCT_SERVICE) LIKE UPPER('%{$this->keyword}%')
                 OR UPPER(EXT_GEONAME_COUNTRY.COUNTRY) LIKE UPPER('%{$this->keyword}%')
                )
            ";
        }

        if ($this->industry)
        {
            $wheres[] = "EMT_COMPANY.SECTOR_ID={$this->industry->getId()}";
        }

        if ($this->country)
        {
            $wheres[] = "UPPER(EMT_CONTACT_ADDRESS.COUNTRY)='{$this->country}'";
        }

        $this->pager = $this->sesuser->getConnections(PrivacyNodeTypePeer::PR_NTYP_COMPANY, null, true, true, null, false, 20, $this->page, array('joins' => $joins, 'wheres' => $wheres));
    }

    public function handleError()
    {
    }

}
