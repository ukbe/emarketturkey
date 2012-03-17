<?php

class directoryAction extends EmtAction
{
    public function execute($request)
    {
        $this->substitute = $this->getRequestParameter('substitute');
        
        $this->initial = $this->country = $this->industry = null;
        
        $this->mod = null;
        
        if (preg_match('/^([A-Za-z]|@){1}$/', $this->substitute))
        {
            $this->initial = strtoupper($this->substitute);
        }
        else
        {
            $this->country = CountryPeer::retrieveByStrippedName(strtolower($this->substitute));
            if (!$this->country)
            {
                $this->industry = BusinessSectorPeer::retrieveByStrippedName(strtolower($this->substitute));
            }
        }
        
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;

        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(TradeExpertPeer::ID, TradeExpertI18nPeer::ID, Criteria::LEFT_JOIN);
            $c1 = $c->getNewCriterion(TradeExpertI18nPeer::NAME, "UPPER(".TradeExpertI18nPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(TradeExpertI18nPeer::INTRODUCTION, "UPPER(".TradeExpertI18nPeer::INTRODUCTION.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c->add($c1);
        }

        $i18n = $this->getContext()->getI18N();

        if ($this->initial)
        {
            $this->getResponse()->setTitle('Trade Experts by Name | eMarketTurkey');

            $this->mod = 3;
            $c->addJoin(TradeExpertPeer::ID, TradeExpertI18nPeer::ID, Criteria::LEFT_JOIN);
            if ($this->initial == '@')
            {
                $c->add(TradeExpertI18nPeer::NAME, myTools::NLSFunc("SUBSTR(".TradeExpertI18nPeer::NAME.", 0, 1)", 'UPPER'). " NOT IN ('".implode("','", range('A','Z'))."')", Criteria::CUSTOM);
            }
            else
            {
                $c->add(TradeExpertI18nPeer::NAME, myTools::NLSFunc("SUBSTR(".TradeExpertI18nPeer::NAME.", 0, 1)", 'UPPER'). "='{$this->initial}'", Criteria::CUSTOM);
            }
            $c->addAscendingOrderByColumn(TradeExpertI18nPeer::NAME, myTools::NLSFunc(TradeExpertI18nPeer::NAME, 'SORT'));
            $c->add(TradeExpertI18nPeer::CULTURE, $this->getUser()->getCulture());
        }

        if ($this->industry)
        {
            $this->getResponse()->setTitle($i18n->__('Trade Experts related to %1 Industry', array('%1' => $this->industry)). ' | eMarketTurkey');
            $this->mod = 1;
            $c->addJoin(TradeExpertPeer::ID, TradeExpertIndustryPeer::ID, Criteria::LEFT_JOIN);
            $c->add(TradeExpertIndustryPeer::INDUSTRY_ID, $this->industry->getId());
        }

        if ($this->country)
        {
            $this->getResponse()->setTitle($i18n->__('Trade Experts for %1 Market', array('%1' => $this->country)). ' | eMarketTurkey');
            $this->mod = 2;
            $c->addJoin(TradeExpertPeer::ID, TradeExpertAreaPeer::ID, Criteria::LEFT_JOIN);
            $c->add(TradeExpertAreaPeer::COUNTRY, "UPPER(".TradeExpertAreaPeer::COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);
        }
        
        if ($this->mod === null) $this->redirect("@tradeexperts");
        
        $c->add(TradeExpertPeer::STATUS, TradeExpertPeer::TX_STAT_APPROVED);
        
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
