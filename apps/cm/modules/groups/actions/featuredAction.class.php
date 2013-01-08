<?php

class featuredAction extends EmtAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.groups-action?".http_build_query($params), 301);

        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->type = is_numeric($this->getRequestParameter('type')) ? GroupTypePeer::retrieveByPK($this->getRequestParameter('type')) : null;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('country')) : '';

        $c = new Criteria();
        
        if ($this->keyword)
        {
            $c1 = $c->getNewCriterion(GroupPeer::NAME, "UPPER(".GroupPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c->addJoin(GroupPeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactAddressPeer::COUNTRY, GeonameCountryPeer::CURRENCY_CODE, Criteria::LEFT_JOIN);
            $c2 = $c->getNewCriterion(GroupI18nPeer::ABBREVIATION, "UPPER(".GroupI18nPeer::ABBREVIATION.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c3 = $c->getNewCriterion(GroupI18nPeer::DISPLAY_NAME, "UPPER(".GroupI18nPeer::DISPLAY_NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c4 = $c->getNewCriterion(GroupI18nPeer::INTRODUCTION, "UPPER(".GroupI18nPeer::INTRODUCTION.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c5 = $c->getNewCriterion(GroupI18nPeer::EVENTS_INTRODUCTION, "UPPER(".GroupI18nPeer::EVENTS_INTRODUCTION.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c6 = $c->getNewCriterion(GroupI18nPeer::MEMBER_PROFILE, "UPPER(".GroupI18nPeer::MEMBER_PROFILE.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c7 = $c->getNewCriterion(GeonameCountryPeer::COUNTRY, "UPPER(".GeonameCountryPeer::COUNTRY.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c1->addOr($c3);
            $c1->addOr($c4);
            $c1->addOr($c5);
            $c1->addOr($c6);
            $c1->addOr($c7);
            $c->add($c1);
        }

        if ($this->type)
        {
            $c->add(GroupPeer::TYPE_ID, $this->type->getId());
        }

        if ($this->country)
        {
            $c->addJoin(GroupPeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->add(ContactAddressPeer::COUNTRY, "UPPER(".ContactAddressPeer::COUNTRY.") = '{$this->country}'", Criteria::CUSTOM);
        }

        $c->add(GroupPeer::IS_FEATURED, 1);
        $c->setDistinct();
        
        $pager = new sfPropelPager('Group', 20);
        $pager->setPage($this->page);
        $pager->setCriteria($c);
        $pager->init();
        $this->pager = $pager;
    }

    public function handleError()
    {
    }

}
