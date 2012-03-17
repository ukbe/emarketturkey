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
        }

        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;

        $c = new Criteria();
        if ($this->keyword)
        {
            $c1 = $c->getNewCriterion(UserPeer::NAME, myTools::NLSFunc(UserPeer::NAME . " || ' ' || " . UserPeer::LASTNAME) . " LIKE " . myTools::NLSFunc("'%{$this->keyword}%'", 'UPPER'), Criteria::CUSTOM);
            $c->addJoin(UserPeer::PROFILE_ID, UserProfilePeer::ID, Criteria::INNER_JOIN);
            $c->addJoin(UserProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::INNER_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactAddressPeer::COUNTRY, GeonameCountryPeer::CURRENCY_CODE, Criteria::LEFT_JOIN);
            $c2 = $c->getNewCriterion(UserPeer::DISPLAY_NAME, myTools::NLSFunc(UserPeer::DISPLAY_NAME, 'UPPER') . " || ' ' || " . myTools::NLSFunc(UserPeer::DISPLAY_NAME, 'UPPER') . " LIKE " . myTools::NLSFunc("'%{$this->keyword}%'", 'UPPER'), Criteria::CUSTOM);
            $c3 = $c->getNewCriterion(GeonameCountryPeer::COUNTRY, myTools::NLSFunc(GeonameCountryPeer::COUNTRY, 'UPPER')." LIKE " . myTools::NLSFunc("'%{$this->keyword}%'" , 'UPPER'), Criteria::CUSTOM);
            $c1->addOr($c2);
            $c1->addOr($c3);
            $c->add($c1);
        }

        if ($this->initial)
        {
            $this->mod = 3;
            if ($this->initial == '@')
            {
                $c->add(UserPeer::DISPLAY_NAME, "UPPER(SUBSTR(".UserPeer::DISPLAY_NAME.", 0, 1)) NOT IN ('".implode("','", range('A','Z'))."')", Criteria::CUSTOM);
            }
            else
            {
                $c->add(UserPeer::DISPLAY_NAME, "UPPER(SUBSTR(".UserPeer::DISPLAY_NAME.", 0, 1))='{$this->initial}'", Criteria::CUSTOM);
            }
            $c->addAscendingOrderByColumn(myTools::NLSFunc(UserPeer::DISPLAY_NAME, 'SORT'));
            $c->addAscendingOrderByColumn(myTools::NLSFunc(UserPeer::DISPLAY_LASTNAME, 'SORT'));
        }

        if ($this->country)
        {
            $this->mod = 2;
            $c->addJoin(UserPeer::PROFILE_ID, UserProfilePeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(UserProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->add(ContactAddressPeer::COUNTRY, "UPPER(".ContactAddressPeer::COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);
        }
        
        if ($this->mod === null) $this->redirect("@people");
        
        $c->setDistinct();
        
        $pager = new sfPropelPager('User', 20);
        $pager->setPage($this->page);
        $pager->setCriteria($c);
        $pager->init();
        $this->pager = $pager;
    }

    public function handleError()
    {
    }

}
