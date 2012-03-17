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

        $c->setDistinct();

        if ($this->keyword || $this->initial)
        {
            $c->addJoin(EventPeer::ID, EventI18nPeer::ID, Criteria::LEFT_JOIN);
        }

        if ($this->keyword)
        {
            $c1 = $c->getNewCriterion(EventI18nPeer::NAME, "UPPER(".EventI18nPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(EventI18nPeer::INTRODUCTION, "UPPER(".EventI18nPeer::INTRODUCTION.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c3 = $c->getNewCriterion(EventPeer::ORGANISER_NAME, "UPPER(".EventPeer::ORGANISER_NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c4 = $c->getNewCriterion(EventPeer::LOCATION_NAME, "UPPER(".EventPeer::LOCATION_NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c1->addOr($c3);
            $c1->addOr($c4);
            $c->add($c1);
        }

        $i18n = $this->getContext()->getI18N();

        if ($this->initial)
        {
            $this->getResponse()->setTitle('Events by Name | eMarketTurkey');
            $this->mod = 3;
            if ($this->initial == '@')
            {
                $c->add(EventI18nPeer::NAME, myTools::NLSFunc("SUBSTR(".EventI18nPeer::NAME.", 0, 1)", 'UPPER'). " NOT IN ('".implode("','", range('A','Z'))."')", Criteria::CUSTOM);
            }
            else
            {
                $c->add(EventI18nPeer::NAME, myTools::NLSFunc("SUBSTR(".EventI18nPeer::NAME.", 0, 1)", 'UPPER'). "='{$this->initial}'", Criteria::CUSTOM);
            }
            $c->addAscendingOrderByColumn(EventI18nPeer::NAME, myTools::NLSFunc(EventI18nPeer::NAME, 'SORT'));
        }

        if ($this->industry)
        {
            $this->getResponse()->setTitle($i18n->__('Events on %1 Industry', array('%1' => $this->industry)). ' | eMarketTurkey');
            $this->mod = 1;
            //$c->add(EventPeer::CATEGORY_ID, $this->category->getId());
        }

        if ($this->country)
        {
            $this->getResponse()->setTitle($i18n->__('Events in %1', array('%1' => $this->country->getName())). ' | eMarketTurkey');
            $this->mod = 2;
            $c->addJoin(EventPeer::PLACE_ID, PlacePeer::ID, Criteria::LEFT_JOIN);
            $c1 = $c->getNewCriterion(EventPeer::LOCATION_COUNTRY, "UPPER(".EventPeer::LOCATION_COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(PlacePeer::COUNTRY, "UPPER(".PlacePeer::COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c->addAnd($c1);
        }
        
        if ($this->mod === null) $this->redirect("@events");

        //$c->addJoin(EventPeer::TIME_SCHEME_ID, TimeSchemePeer::ID, Criteria::LEFT_JOIN);
        //$c->add(TimeSchemePeer::END_DATE, 'TRUNC(EMT_TIME_SCHEME.END_DATE) >= TRUNC(SYSDATE)', Criteria::CUSTOM);
                
        $c->addJoin(EventPeer::ID, EventI18nPeer::ID, Criteria::LEFT_JOIN);
        
        EventPeer::addSelectColumns($c);
        
        if ($this->initial)
        {
            $c->addSelectColumn(EventI18nPeer::NAME);
            $c->addAscendingOrderByColumn(EventI18nPeer::NAME, myTools::NLSFunc(EventI18nPeer::NAME, 'SORT'));
            $c->add(EventI18nPeer::CULTURE, $this->getUser()->getCulture());
        }
        else
        {
            $c->addJoin(EventPeer::TIME_SCHEME_ID, TimeSchemePeer::ID, Criteria::LEFT_JOIN);
            $c->addSelectColumn(TimeSchemePeer::START_DATE);
            $c->addAscendingOrderByColumn(TimeSchemePeer::START_DATE);
        }

        $pager = new sfPropelPager('Event', 20);
        $pager->setPage($this->page);
        $pager->setCriteria($c);
        $pager->init();
        $this->pager = $pager;
    }

    public function handleError()
    {
    }

}
