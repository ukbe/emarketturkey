<?php

class directoryAction extends EmtAction
{
    public function execute($request)
    {
        $this->substitute = $this->getRequestParameter('substitute');
        
        $this->initial = $this->country = $this->types = null;
        
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

        if ($this->keyword || $this->initial)
        {
            $c->addJoin(GroupPeer::ID, GroupI18nPeer::ID, Criteria::INNER_JOIN);
        }

        if ($this->keyword)
        {
            $c1 = $c->getNewCriterion(GroupPeer::NAME, myTools::NLSFunc(GroupPeer::NAME, 'UPPER') . ' LIKE ' . myTools::NLSFunc('%{$this->keyword}%', 'UPPER'), Criteria::CUSTOM);
            $c->addJoin(GroupPeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactAddressPeer::COUNTRY, GeonameCountryPeer::CURRENCY_CODE, Criteria::LEFT_JOIN);
            $c2 = $c->getNewCriterion(GroupI18nPeer::ABBREVIATION, myTools::NLSFunc(GroupI18nPeer::ABBREVIATION, 'UPPER') . ' LIKE ' . myTools::NLSFunc('%{$this->keyword}%', 'UPPER'), Criteria::CUSTOM);
            $c3 = $c->getNewCriterion(GroupI18nPeer::DISPLAY_NAME, myTools::NLSFunc(GroupI18nPeer::DISPLAY_NAME, 'UPPER') . ' LIKE ' . myTools::NLSFunc('%{$this->keyword}%', 'UPPER'), Criteria::CUSTOM);
            $c4 = $c->getNewCriterion(GroupI18nPeer::INTRODUCTION, myTools::NLSFunc(GroupI18nPeer::INTRODUCTION, 'UPPER') . ' LIKE ' . myTools::NLSFunc('%{$this->keyword}%', 'UPPER'), Criteria::CUSTOM);
            $c5 = $c->getNewCriterion(GroupI18nPeer::EVENTS_INTRODUCTION, myTools::NLSFunc(GroupI18nPeer::EVENTS_INTRODUCTION, 'UPPER') . ' LIKE ' . myTools::NLSFunc('%{$this->keyword}%', 'UPPER'), Criteria::CUSTOM);
            $c6 = $c->getNewCriterion(GroupI18nPeer::MEMBER_PROFILE, myTools::NLSFunc(GroupI18nPeer::MEMBER_PROFILE, 'UPPER') . ' LIKE ' . myTools::NLSFunc('%{$this->keyword}%', 'UPPER'), Criteria::CUSTOM);
            $c7 = $c->getNewCriterion(GeonameCountryPeer::COUNTRY, myTools::NLSFunc(GeonameCountryPeer::COUNTRY, 'UPPER') . ' LIKE ' . myTools::NLSFunc('%{$this->keyword}%', 'UPPER'), Criteria::CUSTOM);
            $c1->addOr($c2);
            $c1->addOr($c3);
            $c1->addOr($c4);
            $c1->addOr($c5);
            $c1->addOr($c6);
            $c1->addOr($c7);
            $c->add($c1);
        }

        if ($this->initial)
        {
            $this->getResponse()->setTitle('Groups by Name | eMarketTurkey');

            $this->mod = 3;
            if ($this->initial == '@')
            {
                $c1 = $c->getNewCriterion(GroupPeer::NAME, "UPPER(SUBSTR(".GroupPeer::DISPLAY_NAME.", 0, 1)) NOT IN ('".implode("','", range('A','Z'))."')", Criteria::CUSTOM);
                $c2 = $c->getNewCriterion(GroupI18nPeer::DISPLAY_NAME, "UPPER(SUBSTR(".GroupI18nPeer::DISPLAY_NAME.", 0, 1)) NOT IN ('".implode("','", range('A','Z'))."')", Criteria::CUSTOM);
                $c1->addOr($c2);
                $c->add($c1);
            }
            else
            {
                $c1 = $c->getNewCriterion(GroupPeer::NAME, "UPPER(SUBSTR(".GroupPeer::NAME.", 0, 1))='{$this->initial}'", Criteria::CUSTOM);
                $c2 = $c->getNewCriterion(GroupI18nPeer::DISPLAY_NAME, "UPPER(SUBSTR(".GroupI18nPeer::DISPLAY_NAME.", 0, 1))='{$this->initial}'", Criteria::CUSTOM);
                $c1->addOr($c2);
                $c->add($c1);
            }
            $c->addAscendingOrderByColumn(myTools::NLSFunc(GroupI18nPeer::DISPLAY_NAME, 'SORT'));
        }

        if ($this->country)
        {
            $this->mod = 2;
            $c->addJoin(GroupPeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->add(ContactAddressPeer::COUNTRY, "UPPER(".ContactAddressPeer::COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);
        }
        
        if (!$this->initial && !$this->country && !$this->mod)
        {
            $this->countries = $this->getRequestParameter('country', array());
            if (!is_array($this->countries)) $this->countries = array($this->countries);
            foreach ($this->countries as $key => $code)
            {
                $this->countries[$key] = strtoupper(substr($code, 0, 2));
            }
            $this->types = $this->getRequestParameter('gtype', array());
            if (!is_array($this->types)) $this->types = array($this->types);
            foreach ($this->types as $key => $type_id)
            {
                $this->types[$key] = (is_numeric($type_id) ? $type_id : 0);
            }
            if (count($this->countries))
            {
                if (!$this->keyword)
                {
                    $c->addJoin(GroupPeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
                }
                $c->add(ContactAddressPeer::COUNTRY, $this->countries, Criteria::IN);
            }
            
            if (count($this->types))
            {
                $c->add(GroupPeer::TYPE_ID, $this->types, Criteria::IN);
            }
            
            if (!count($this->countries) && !count($this->types) && !$this->keyword) $this->redirect('@groups');

            $this->mod = 1;
        }
        else
        {
            $this->redirect("@groups");
        }
        
        
        $c->addJoin(GroupPeer::ID, GroupI18nPeer::ID, Criteria::LEFT_JOIN);
        
        GroupPeer::addSelectColumns($c);
        
        $c->addSelectColumn(GroupI18nPeer::DISPLAY_NAME);
        $c->addAscendingOrderByColumn(GroupI18nPeer::DISPLAY_NAME, myTools::NLSFunc(GroupI18nPeer::DISPLAY_NAME, 'SORT'));
        $c->add(GroupI18nPeer::CULTURE, $this->getUser()->getCulture());
        
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
