<?php

class networkAction extends EmtAction
{
    public function execute($request)
    {
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->category = is_numeric($this->getRequestParameter('category')) ? ProductCategoryPeer::retrieveByPK($this->getRequestParameter('category')) : null;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('country')) : '';
        
        $joins = $wheres = array();
        
        if ($this->keyword)
        {
            $joins[] = "INNER JOIN EMT_PRODUCT_I18N ON EMT_PRODUCT.ID=EMT_PRODUCT_I18N.ID";
            $joins[] = "LEFT JOIN EMT_COMPANY_BRAND ON EMT_PRODUCT.BRAND_ID=EMT_COMPANY_BRAND.ID";
            $wheres[] = "
                (
                    UPPER(EMT_PRODUCT.MODEL_NO) LIKE UPPER('%{$this->keyword}%')
                 OR UPPER(EMT_PRODUCT.KEYWORD) LIKE UPPER('%{$this->keyword}%')
                 OR UPPER(EMT_PRODUCT.BRAND_NAME) LIKE UPPER('%{$this->keyword}%')
                 OR UPPER(EMT_PRODUCT_I18N.NAME) LIKE UPPER('%{$this->keyword}%')
                 OR UPPER(EMT_PRODUCT_I18N.INTRODUCTION) LIKE UPPER('%{$this->keyword}%')
                 OR UPPER(EMT_PRODUCT_I18N.PACKAGING) LIKE UPPER('%{$this->keyword}%')
                 OR UPPER(EMT_COMPANY_BRAND.NAME) LIKE UPPER('%{$this->keyword}%')
                )
            ";
        }

        if ($this->category)
        {
            $wheres[] = "EMT_PRODUCT.CATEGORY_ID={$this->category->getId()}";
        }

        if ($this->country)
        {
            $joins[] = "LEFT JOIN EMT_COMPANY_PROFILE ON EMT_COMPANY.PROFILE_ID=EMT_COMPANY_PROFILE.ID";
            $joins[] = "LEFT JOIN EMT_CONTACT ON EMT_COMPANY_PROFILE.CONTACT_ID=EMT_CONTACT.ID";
            $joins[] = "LEFT JOIN EMT_CONTACT_ADDRESS ON EMT_CONTACT.ID=EMT_CONTACT_ADDRESS.CONTACT_ID";
            $wheres[] = "UPPER(EMT_CONTACT_ADDRESS.COUNTRY)='{$this->country}'";
        }

        $this->pager = $this->sesuser->getConnections(PrivacyNodeTypePeer::PR_NTYP_COMPANY, null, true, true, null, false, 20, $this->page, array('joins' => $joins, 'wheres' => $wheres), PrivacyNodeTypePeer::PR_NTYP_PRODUCT);
    }

    public function handleError()
    {
    }

}
