<?php

class directoryAction extends EmtAction
{
    protected $i18n_object_depended = true;

    public function execute($request)
    {
        $xcult = myTools::pick_from_list($this->getRequestParameter('x-cult'), sfConfig::get('app_i18n_cultures'), null);

        $this->substitute = $this->getRequestParameter('substitute');
        
        $this->initial = $this->country = null;
        
        $this->mod = null;
        
        if (preg_match('/^([A-Za-z]|@){1}$/', $this->substitute))
        {
            $this->initial = strtoupper($this->substitute);
        }
        else
        {
            $this->country = CountryPeer::retrieveByStrippedName(strtolower($this->substitute), $xcult);
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
            $c2 = $c->getNewCriterion(UserPeer::DISPLAY_NAME, myTools::NLSFunc(UserPeer::DISPLAY_NAME . " || " . UserPeer::DISPLAY_LASTNAME, 'UPPER') . " LIKE " . myTools::NLSFunc("'%{$this->keyword}%'", 'UPPER'), Criteria::CUSTOM);
            $c3 = $c->getNewCriterion(GeonameCountryPeer::COUNTRY, myTools::NLSFunc(GeonameCountryPeer::COUNTRY, 'UPPER')." LIKE " . myTools::NLSFunc("'%{$this->keyword}%'" , 'UPPER'), Criteria::CUSTOM);
            $c1->addOr($c2);
            $c1->addOr($c3);
            $c->add($c1);
        }

        $urls = array();

        if ($this->initial)
        {
            $this->getResponse()->setTitle('People by Name | eMarketTurkey');

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
                $c->add(UserPeer::DISPLAY_NAME, myTools::NLSFunc("SUBSTR(".UserPeer::DISPLAY_NAME.", 0, 1)")." NOT IN ('".implode("','", $abc)."')", Criteria::CUSTOM);
            }
            else
            {
                $c->add(UserPeer::DISPLAY_NAME, myTools::NLSFunc("SUBSTR(".UserPeer::DISPLAY_NAME.", 0, 1)")." IN ('".implode("','", isset($substitutes[$this->initial]) ?  $substitutes[$this->initial] : array($this->initial))."')", Criteria::CUSTOM);
            }
            $c->addAscendingOrderByColumn(myTools::NLSFunc(UserPeer::DISPLAY_NAME, 'SORT'));
            $c->addAscendingOrderByColumn(myTools::NLSFunc(UserPeer::DISPLAY_LASTNAME, 'SORT'));

            foreach (sfConfig::get('app_i18n_cultures') as $culture)
            {
                $urls[$culture] = "@people-dir?substitute={$this->initial}&sf_culture=$culture";
            }
        }

        if ($this->country)
        {
            $this->getResponse()->setTitle('People by Country | eMarketTurkey');

            $this->mod = 2;
            $c->addJoin(UserPeer::PROFILE_ID, UserProfilePeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(UserProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->add(ContactAddressPeer::COUNTRY, "UPPER(".ContactAddressPeer::COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);

            foreach (sfConfig::get('app_i18n_cultures') as $culture)
            {
                $urls[$culture] = "@people-dir?substitute=".$this->country->getStrippedName($culture)."&sf_culture=$culture";
            }
        }
        
        if (!$this->initial && !$this->country && !$this->mod)
        {
            $this->countries = $this->getRequestParameter('country', array());
            if (!is_array($this->countries)) $this->countries = array($this->countries);
            foreach ($this->countries as $key => $code)
            {
                $this->countries[$key] = strtoupper(substr($code, 0, 2));
            }
            if (count($this->countries))
            {
                if (!$this->keyword)
                {
                    $c->addJoin(UserPeer::PROFILE_ID, UserProfilePeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(UserProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
                    $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
                }
                $c->add(ContactAddressPeer::COUNTRY, $this->countries, Criteria::IN);
            }
            
            if (!count($this->countries) && !$this->keyword) $this->redirect('@people');

            $this->mod = 1;
        }
        
        if ($xcult)
        {
            $this->redirect($urls[$xcult]);
        }

        $this->getUser()->setCultureLinks($urls);

        $c->add(UserPeer::ID, "NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE EMT_BLOCKLIST.LOGIN_ID=EMT_USER.LOGIN_ID)", Criteria::CUSTOM);

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
