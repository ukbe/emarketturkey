<?php

class featuredAction extends EmtAction
{
    public function execute($request)
    {
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->industry = null; //is_numeric($this->getRequestParameter('cm_industry')) ? BusinessSectorPeer::retrieveByPK($this->getRequestParameter('cm_industry')) : null;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('country')) : '';
        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(EventPeer::ID, EventI18nPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(EventPeer::PLACE_ID, PlacePeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(PlacePeer::ID, PlaceI18nPeer::ID, Criteria::LEFT_JOIN);
            $c1 = $c->getNewCriterion(EventI18nPeer::NAME, "UPPER(".EventI18nPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(EventI18nPeer::INTRODUCTION, "UPPER(".EventI18nPeer::INTRODUCTION.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c3 = $c->getNewCriterion(PlaceI18nPeer::NAME, "UPPER(".PlaceI18nPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c1->addOr($c3);
            $c->add($c1);
        }

        /*
        if ($this->industry)
        {
            $c->add(EventPeer::SECTOR_ID, $this->industry->getId());
        }
        */

        if ($this->country)
        {
            $c->addJoin(EventPeer::PLACE_ID, PlacePeer::ID, Criteria::LEFT_JOIN);
            $c->add(PlacePeer::COUNTRY, "UPPER(".PlacePeer::COUNTRY.") = '{$this->country}'", Criteria::CUSTOM);
        }

        $c->setDistinct();
        
        $c->addJoin(EventPeer::TYPE_ID, EventTypePeer::ID);
        $c->addJoin(EventPeer::TIME_SCHEME_ID, TimeSchemePeer::ID);
        
        $c4 = $c->getNewCriterion(EventTypePeer::TYPE_CLASS, EventTypePeer::ECLS_TYP_BUSINESS);
        $c5 = $c->getNewCriterion(EventTypePeer::TYPE_CLASS, null, Criteria::ISNULL);
        $c4->addOr($c5);
        $c->addAnd($c4);
        
        $c->add(TimeSchemePeer::END_DATE, 'TRUNC(EMT_TIME_SCHEME.END_DATE) >= TRUNC(SYSDATE)', Criteria::CUSTOM);
        $c->add(EventPeer::IS_FEATURED, 1);
        EventPeer::addSelectColumns($c);
        $c->addSelectColumn(TimeSchemePeer::START_DATE);
        $c->addAscendingOrderByColumn(TimeSchemePeer::START_DATE);

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
