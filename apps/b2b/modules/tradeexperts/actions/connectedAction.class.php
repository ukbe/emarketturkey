<?php

class connectedAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.tradeexperts-action?".http_build_query($params), 301);

        $types = array(PrivacyNodeTypePeer::PR_NTYP_COMPANY, PrivacyNodeTypePeer::PR_NTYP_USER);
        $this->type_id = myTools::pick_from_list($this->getRequestParameter('type'), $types, null);

        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->industry = is_numeric($this->getRequestParameter('industry')) ? BusinessSectorPeer::retrieveByPK($this->getRequestParameter('industry')) : null;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('country')) : '';
        
        $joins = $wheres = array();
        
        $wheres = array("EMT_TRADE_EXPERT.STATUS=".TradeExpertPeer::TX_STAT_APPROVED);
        if ($this->type_id) $wheres[] = array("EMT_TRADE_EXPERT.HOLDER_TYPE_ID={$this->type_id}");
        
        if ($this->keyword)
        {
            $joins[] = "INNER JOIN EMT_TRADE_EXPERT_I18N ON EMT_TRADE_EXPERT.ID=EMT_TRADE_EXPERT_I18N.ID";
            $wheres[] = "
                (
                    UPPER(EMT_TRADE_EXPERT_I18N.NAME) LIKE UPPER('%{$this->keyword}%')
                 OR UPPER(EMT_TRADE_EXPERT_I18N.INTRODUCTION) LIKE UPPER('%{$this->keyword}%')
                )
            ";
        }

        if ($this->industry)
        {
            $joins[] = "INNER JOIN EMT_TRADE_EXPERT_INDUSTRY ON EMT_TRADE_EXPERT.ID=EMT_TRADE_EXPERT_INDUSTRY.ID";
            $wheres[] = "EMT_TRADE_EXPERT_INDUSTRY.INDUSTRY_ID={$this->industry->getId()}";
        }

        if ($this->country)
        {
            $joins[] = "INNER JOIN EMT_TRADE_EXPERT_AREA ON EMT_TRADE_EXPERT.ID=EMT_TRADE_EXPERT_AREA.ID";
            $wheres[] = "UPPER(EMT_TRADE_EXPERT_AREA.COUNTRY)='{$this->country}'";
        }

        $this->pager = $this->sesuser->getConnections(null, null, true, true, null, false, 20, $this->page, array('joins' => $joins, 'wheres' => $wheres), PrivacyNodeTypePeer::PR_NTYP_TRADE_EXPERT);
        
    }

    public function handleError()
    {
    }

}
