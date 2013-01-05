<?php

class networkAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.leads-action?".http_build_query($params), 301);

        $types = array('selling' => B2bLeadPeer::B2B_LEAD_SELLING, 'buying' => B2bLeadPeer::B2B_LEAD_BUYING);
        $this->type_code = myTools::pick_from_list($this->getRequestParameter('type_code'), array_keys($types), null);
        $this->type_id = in_array($this->type_code, array_keys($types)) ? $types[$this->type_code] : null;
        if (!$this->type_id) $this->redirect('@homepage');

        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->category = is_numeric($this->getRequestParameter('category')) ? ProductCategoryPeer::retrieveByPK($this->getRequestParameter('category')) : null;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('p_country')) : '';
        
        $joins = $wheres = array();
        
        $wheres = array("EMT_B2B_LEAD.TYPE_ID={$this->type_id} AND (TRUNC(EMT_B2B_LEAD.EXPIRES_AT) >= TRUNC(SYSDATE))");
        
        if ($this->keyword)
        {
            $joins[] = "INNER JOIN EMT_B2B_LEAD_I18N ON EMT_B2B_LEAD.ID=EMT_B2B_LEAD_I18N.ID";
            $wheres[] = "
                (
                    UPPER(EMT_B2B_LEAD_I18N.NAME) LIKE UPPER('%{$this->keyword}%')
                 OR UPPER(EMT_B2B_LEAD_I18N.DESCRIPTION) LIKE UPPER('%{$this->keyword}%')
                )
            ";
        }

        if ($this->category)
        {
            $wheres[] = "EMT_B2B_LEAD.CATEGORY_ID={$this->category->getId()}";
        }

        if ($this->country)
        {
            $joins[] = "LEFT JOIN EMT_COMPANY_PROFILE ON EMT_COMPANY.PROFILE_ID=EMT_COMPANY_PROFILE.ID";
            $joins[] = "LEFT JOIN EMT_CONTACT ON EMT_COMPANY_PROFILE.CONTACT_ID=EMT_CONTACT.ID";
            $joins[] = "LEFT JOIN EMT_CONTACT_ADDRESS ON EMT_CONTACT.ID=EMT_CONTACT_ADDRESS.CONTACT_ID";
            $wheres[] = "UPPER(EMT_CONTACT_ADDRESS.COUNTRY)='{$this->country}'";
        }

        $this->pager = $this->sesuser->getConnections(PrivacyNodeTypePeer::PR_NTYP_COMPANY, null, true, true, null, false, 20, $this->page, array('joins' => $joins, 'wheres' => $wheres), PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD);
        
    }

    public function handleError()
    {
    }

}
