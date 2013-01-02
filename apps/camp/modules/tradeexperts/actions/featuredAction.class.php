<?php

class featuredAction extends EmtAction
{
    public function execute($request)
    {
        $types = array(PrivacyNodeTypePeer::PR_NTYP_COMPANY, PrivacyNodeTypePeer::PR_NTYP_USER);
        $this->type_id = myTools::pick_from_list($this->getRequestParameter('type'), $types, null);

        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->industry = is_numeric($this->getRequestParameter('industry')) ? BusinessSectorPeer::retrieveByPK($this->getRequestParameter('industry')) : null;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('country')) : '';
        
        $c = new Criteria();
        
        $c->add(TradeExpertPeer::STATUS, TradeExpertPeer::TX_STAT_APPROVED);
        
        if ($this->type_id) $c->add(TradeExpertPeer::HOLDER_TYPE_ID, $this->type_id);
        
        if ($this->keyword)
        {
            $c->addJoin(TradeExpertPeer::ID, TradeExpertI18nPeer::ID, Criteria::INNER_JOIN);
            $c1 = $c->getNewCriterion(TradeExpertI18nPeer::NAME, "UPPER(".TradeExpertI18nPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(TradeExpertI18nPeer::INTRODUCTION, "UPPER(".TradeExpertI18nPeer::INTRODUCTION.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c->addAnd($c1);
        }

        if ($this->industry)
        {
            $c->addJoin(TradeExpertPeer::ID, TradeExpertIndustryPeer::ID, Criteria::INNER_JOIN);
            $c->add(TradeExpertIndustryPeer::INDUSTRY_ID, $this->industry->getId());
        }

        if ($this->country)
        {
            $c->addJoin(TradeExpertPeer::ID, TradeExpertAreaPeer::ID, Criteria::INNER_JOIN);
            $c->add(TradeExpertAreaPeer::COUNTRY, "UPPER(".TradeExpertAreaPeer::COUNTRY.") = '{$this->country}'", Criteria::CUSTOM);
        }
        
        $c->add(TradeExpertPeer::IS_FEATURED, 1);

        $pager = new sfPropelPager('TradeExpert', 20);
        $pager->setPage($this->page);
        $pager->setCriteria($c);
        $pager->init();
        $this->pager = $pager;
    }

    public function handleError()
    {
    }

}
