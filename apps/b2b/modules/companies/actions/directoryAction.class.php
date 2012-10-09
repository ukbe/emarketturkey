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
            $c1 = $c->getNewCriterion(CompanyPeer::NAME, myTools::NLSFunc(CompanyPeer::NAME, 'UPPER')." LIKE ".myTools::NLSFunc("'%{$this->keyword}%'"), Criteria::CUSTOM);
            $c->addJoin(CompanyPeer::PROFILE_ID, CompanyProfilePeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(CompanyProfilePeer::ID, CompanyProfileI18nPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(CompanyProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactAddressPeer::COUNTRY, GeonameCountryPeer::CURRENCY_CODE, Criteria::LEFT_JOIN);
            $c2 = $c->getNewCriterion(CompanyProfilePeer::CERTIFICATIONS, myTools::NLSFunc(CompanyProfilePeer::CERTIFICATIONS, 'UPPER')." LIKE ".myTools::NLSFunc("'%{$this->keyword}%'"), Criteria::CUSTOM);
            $c3 = $c->getNewCriterion(CompanyProfileI18nPeer::INTRODUCTION, myTools::NLSFunc(CompanyProfileI18nPeer::INTRODUCTION, 'UPPER')." LIKE ".myTools::NLSFunc("'%{$this->keyword}%'"), Criteria::CUSTOM);
            $c4 = $c->getNewCriterion(CompanyProfileI18nPeer::PRODUCT_SERVICE, myTools::NLSFunc(CompanyProfileI18nPeer::PRODUCT_SERVICE, 'UPPER')." LIKE ".myTools::NLSFunc("'%{$this->keyword}%'"), Criteria::CUSTOM);
            $c5 = $c->getNewCriterion(GeonameCountryPeer::COUNTRY, myTools::NLSFunc(GeonameCountryPeer::COUNTRY, 'UPPER')." LIKE ".myTools::NLSFunc("'%{$this->keyword}%'"), Criteria::CUSTOM);
            $c1->addOr($c2);
            $c1->addOr($c3);
            $c1->addOr($c4);
            $c1->addOr($c5);
            $c->add($c1);
        }

        if ($this->initial)
        {
            $this->getResponse()->setTitle('Companies by Name | eMarketTurkey');
            
            $abc = range('A','Z');

            $substitutes = array('C' => array('C', 'Ç'),
                                 'G' => array('G', 'Ğ'),
                                 'I' => array('I', 'İ'),
                                 'O' => array('O', 'Ö'),
                                 'S' => array('S', 'Ş'),
                                 'U' => array('U', 'Ü'),
                            );

            foreach ($substitutes as $subs)
                $abc = array_merge($abc, $subs);

            $abc = array_unique($abc);
            
            $this->mod = 3;
            if ($this->initial == '@')
            {
                $c->add(CompanyPeer::NAME, myTools::NLSFunc("SUBSTR(".CompanyPeer::NAME.", 0, 1)", 'UPPER'). " NOT IN ('".implode("','", $abc)."')", Criteria::CUSTOM);
            }
            else
            {
                $c->add(CompanyPeer::NAME, myTools::NLSFunc("SUBSTR(".CompanyPeer::NAME.", 0, 1)", 'UPPER'). " IN ('".implode("','", isset($substitutes[$this->initial]) ?  $substitutes[$this->initial] : $this->initial)."')", Criteria::CUSTOM);
            }
            $c->addAscendingOrderByColumn(CompanyPeer::NAME, myTools::NLSFunc(CompanyPeer::NAME, 'SORT'));
        }

        if ($this->industry)
        {
            $this->getResponse()->setTitle('Companies by Industry | eMarketTurkey');

            $this->mod = 1;
            $c->add(CompanyPeer::SECTOR_ID, $this->industry->getId());
        }

        if ($this->country)
        {
            $this->getResponse()->setTitle('Companies by Country | eMarketTurkey');

            $this->mod = 2;
            $c->addJoin(CompanyPeer::PROFILE_ID, CompanyProfilePeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(CompanyProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->add(ContactAddressPeer::COUNTRY, "UPPER(".ContactAddressPeer::COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);
        }
        
        if (!$this->initial && !$this->country && !$this->industry && !$this->mod)
        {
            $this->countries = $this->getRequestParameter('country', array());
            if (!is_array($this->countries)) $this->countries = array($this->countries);
            foreach ($this->countries as $key => $code)
            {
                $this->countries[$key] = strtoupper(substr($code, 0, 2));
            }
            $this->industries = $this->getRequestParameter('industry', array());
            if (!is_array($this->industries)) $this->industries = array($this->industries);
            foreach ($this->industries as $key => $sect_id)
            {
                $this->industries[$key] = (is_numeric($sect_id) ? $sect_id : 0);
            }
            $this->btypes = $this->getRequestParameter('btype', array());
            if (!is_array($this->btypes)) $this->btypes = array($this->btypes);
            foreach ($this->btypes as $key => $btype_id)
            {
                $this->btypes[$key] = (is_numeric($btype_id) ? $btype_id : 0);
            }
            if (count($this->countries))
            {
                if (!$this->keyword)
                {
                    $c->addJoin(CompanyPeer::PROFILE_ID, CompanyProfilePeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(CompanyProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
                }
                $c->add(ContactAddressPeer::COUNTRY, $this->countries, Criteria::IN);
            }
            
            if (count($this->industries))
            {
                $c->add(CompanyPeer::SECTOR_ID, $this->industries, Criteria::IN);
            }
            
            if (count($this->btypes))
            {
                $c->add(CompanyPeer::BUSINESS_TYPE_ID, $this->btypes, Criteria::IN);
            }
            
            if (!count($this->countries) && !count($this->industries) && !count($this->btypes) && !$this->keyword) $this->redirect('@companies');

            $this->mod = 4;
        }
        
        $c->setDistinct();
        
        $pager = new sfPropelPager('Company', 20);
        $pager->setPage($this->page);
        $pager->setCriteria($c);
        $pager->init();
        $this->pager = $pager;
    }

    public function handleError()
    {
    }

}
