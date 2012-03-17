<?php

class attendersAction extends EmtAction
{
    public function execute($request)
    {
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->industry = null; //is_numeric($this->getRequestParameter('industry')) ? BusinessSectorPeer::retrieveByPK($this->getRequestParameter('industry')) : null;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('country')) : '';
        
        $joins = $wheres = array();
        
        $joins[] = "LEFT JOIN EMT_EVENT ON EMT_EVENT_INVITE.EVENT_ID=EMT_EVENT.ID";
        $joins[] = "LEFT JOIN EMT_TIME_SCHEME ON EMT_EVENT.TIME_SCHEME_ID=EMT_TIME_SCHEME.ID";

        $wheres[] = "TRUNC(EMT_TIME_SCHEME.END_DATE) >= TRUNC(SYSDATE)";

/*        if ($this->keyword || $this->country)
        {
            $joins[] = "LEFT JOIN EMT_EVENT_INVITE ON EMT_EVENT.ID=EMT_EVENT_INVITE.EVENT_ID";
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
                 OR UPPER(EMT_CONTACT.PRODUCT_SERVICE) LIKE UPPER('%{$this->keyword}%')
                )
            ";
        }

        if ($this->industry)
        {
            $wheres[] = "EMT_COMPANY.SECTOR_ID={$this->industry->getId()}";
        }

        if ($this->country)
        {
            $wheres[] = "UPPER(EMT_CONTACT_ADDRESS.COUNTRY)=UPPER('{$this->country}')";
        }
*/
        $this->pager = $this->sesuser->getConnections(null, null, true, true, null, false, 20, $this->page, array('joins' => $joins, 'wheres' => $wheres), PrivacyNodeTypePeer::PR_NTYP_EVENT_INVITE);
    }

    public function handleError()
    {
    }

}
