<?php

class directoryAction extends EmtAction
{
    protected $i18n_object_depended = true;

    public function execute($request)
    {
        $xcult = myTools::pick_from_list($this->getRequestParameter('x-cult'), sfConfig::get('app_i18n_cultures'), null);

        $this->substitute = $this->getRequestParameter('substitute');
        
        $this->initial = $this->country = $this->industry = null;
        
        $this->mod = null;
        
        if (preg_match('/^([A-Za-z]|@){1}$/', $this->substitute))
        {
            $this->initial = strtoupper($this->substitute);
        }
        else
        {
            $this->country = CountryPeer::retrieveByStrippedName(strtolower($this->substitute), $xcult);
            if (!$this->country)
            {
                $this->industry = BusinessSectorPeer::retrieveByStrippedName(strtolower($this->substitute), $xcult);
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

        $urls = array();

        if ($this->initial)
        {
            $this->getResponse()->setTitle('Trade Shows by Name | eMarketTurkey');
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

            foreach (sfConfig::get('app_i18n_cultures') as $culture)
            {
                $urls[$culture] = "@tradeshows-dir?substitute={$this->initial}&sf_culture=$culture";
            }
        }

        if ($this->industry)
        {
            $this->getResponse()->setTitle($i18n->__('Trade Shows on %1 Industry', array('%1' => $this->industry)). ' | eMarketTurkey');
            $this->mod = 1;
            //$c->add(EventPeer::CATEGORY_ID, $this->category->getId());

            foreach (sfConfig::get('app_i18n_cultures') as $culture)
            {
                $urls[$culture] = "@tradeshows-dir?substitute=".$this->industry->getStrippedName($culture)."&sf_culture=$culture";
            }
        }

        if ($this->country)
        {
            $this->getResponse()->setTitle($i18n->__('Trade Shows in %1', array('%1' => $this->country->getName())). ' | eMarketTurkey');
            $this->mod = 2;
            $c->addJoin(EventPeer::PLACE_ID, PlacePeer::ID, Criteria::LEFT_JOIN);
            $c1 = $c->getNewCriterion(EventPeer::LOCATION_COUNTRY, "UPPER(".EventPeer::LOCATION_COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(PlacePeer::COUNTRY, "UPPER(".PlacePeer::COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c->addAnd($c1);

            foreach (sfConfig::get('app_i18n_cultures') as $culture)
            {
                $urls[$culture] = "@tradeshows-dir?substitute=".$this->country->getStrippedName($culture)."&sf_culture=$culture";
            }
        }
        
        if ($xcult)
        {
            $this->redirect($urls[$xcult]);
        }

        $this->getUser()->setCultureLinks($urls);

        if ($this->mod === null) $this->redirect("@tradeshows");

        //$c->addJoin(EventPeer::TIME_SCHEME_ID, TimeSchemePeer::ID, Criteria::LEFT_JOIN);
        //$c->add(TimeSchemePeer::END_DATE, 'TRUNC(EMT_TIME_SCHEME.END_DATE) >= TRUNC(SYSDATE)', Criteria::CUSTOM);
                
        $c->addJoin(EventPeer::ID, EventI18nPeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(EventPeer::TYPE_ID, EventTypePeer::ID, Criteria::LEFT_JOIN);
        $c->add(EventTypePeer::TYPE_CLASS, EventTypePeer::ECLS_TYP_BUSINESS);
        
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
