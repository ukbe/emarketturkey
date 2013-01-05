<?php

class directoryAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.venues-dir?".http_build_query($params), 301);

        $this->substitute = $this->getRequestParameter('substitute');
        
        $this->initial = $this->country = null;
        
        $this->mod = null;
        
        if (preg_match('/^([A-Za-z]|@){1}$/', $this->substitute))
        {
            $this->initial = strtoupper($this->substitute);
        }
        else
        {
            $this->country = CountryPeer::retrieveByStrippedName(strtolower($this->substitute));
        }
        
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;

        $c = new Criteria();
        
        $c->addJoin(PlacePeer::ID, PlaceI18nPeer::ID, Criteria::INNER_JOIN);

        if ($this->keyword)
        {
            $c1 = $c->getNewCriterion(PlaceI18nPeer::NAME, "UPPER(".PlaceI18nPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(PlaceI18nPeer::INTRODUCTION, "UPPER(".PlaceI18nPeer::INTRODUCTION.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c->addAnd($c1);
        }

        $i18n = $this->getContext()->getI18N();

        if ($this->initial)
        {
            $this->getResponse()->setTitle('Venues by Name | eMarketTurkey');
            $this->mod = 3;
            if ($this->initial == '@')
            {
                $c->add(PlaceI18nPeer::NAME, myTools::NLSFunc("SUBSTR(".PlaceI18nPeer::NAME.", 0, 1)", 'UPPER'). " NOT IN ('".implode("','", range('A','Z'))."')", Criteria::CUSTOM);
            }
            else
            {
                $c->add(PlaceI18nPeer::NAME, myTools::NLSFunc("SUBSTR(".PlaceI18nPeer::NAME.", 0, 1)", 'UPPER'). "='{$this->initial}'", Criteria::CUSTOM);
            }
            $c->addAscendingOrderByColumn(PlaceI18nPeer::NAME, myTools::NLSFunc(PlaceI18nPeer::NAME, 'SORT'));
        }

        if ($this->country)
        {
            $this->getResponse()->setTitle($i18n->__('Venues in %1', array('%1' => $this->country->getName())). ' | eMarketTurkey');
            $this->mod = 2;
            $c->add(PlacePeer::COUNTRY, "UPPER(".PlacePeer::COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);
        }

        if ($this->mod === null) $this->redirect("@venues");

        
        PlacePeer::addSelectColumns($c);
        
        $c->setDistinct();
        
        if ($this->initial)
        {
            $c->addJoin(PlacePeer::ID, PlaceI18nPeer::ID);
            $c->addSelectColumn(PlaceI18nPeer::NAME);
            $c->add(PlaceI18nPeer::CULTURE, $this->getUser()->getCulture());
        }
        
        $pager = new sfPropelPager('Place', 20);
        $pager->setPage($this->page);
        $pager->setCriteria($c);
        $pager->init();
        $this->pager = $pager;
    }

    public function handleError()
    {
    }

}
