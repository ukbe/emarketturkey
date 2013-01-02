<?php

class directoryAction extends EmtAction
{
    public function execute($request)
    {
        $types = array('selling' => B2bLeadPeer::B2B_LEAD_SELLING, 'buying' => B2bLeadPeer::B2B_LEAD_BUYING);
        $this->type_code = myTools::pick_from_list($this->getRequestParameter('type_code'), array_keys($types), null);
        $this->type_id = in_array($this->type_code, array_keys($types)) ? $types[$this->type_code] : null;
        if (!$this->type_id) $this->redirect('@homepage');
        
        $this->isbuying = ($this->type_id == B2bLeadPeer::B2B_LEAD_BUYING);

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
                $this->category = ProductCategoryPeer::retrieveByStrippedCategory(strtolower($this->substitute));
            }
        }
        
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;

        if ($this->keyword || $this->initial)
        {
            $c->addJoin(B2bLeadPeer::ID, B2bLeadI18nPeer::ID, Criteria::INNER_JOIN);
        }

        $c = new Criteria();
        
        $c->add(B2bLeadPeer::EXPIRES_AT, "EMT_B2B_LEAD.TYPE_ID={$this->type_id} AND (TRUNC(EMT_B2B_LEAD.EXPIRES_AT) >= TRUNC(SYSDATE))", Criteria::CUSTOM);
        
        if ($this->keyword)
        {
            $c1 = $c->getNewCriterion(B2bLeadI18nPeer::NAME, "UPPER(".B2bLeadI18nPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(B2bLeadI18nPeer::DESCRIPTION, "UPPER(".B2bLeadI18nPeer::DESCRIPTION.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c->add($c1);
        }

        $i18n = $this->getContext()->getI18N();

        if ($this->initial)
        {
            $this->getResponse()->setTitle($this->buying ? 'Buying Leads by Name | eMarketTurkey' : 'Selling Leads by Name | eMarketTurkey');
            $this->mod = 3;
            if ($this->initial == '@')
            {
                $c->add(B2bLeadI18nPeer::NAME, myTools::NLSFunc("SUBSTR(".B2bLeadI18nPeer::NAME.", 0, 1)", 'UPPER'). " NOT IN ('".implode("','", range('A','Z'))."')", Criteria::CUSTOM);
            }
            else
            {
                $c->add(B2bLeadI18nPeer::NAME, myTools::NLSFunc("SUBSTR(".B2bLeadI18nPeer::NAME.", 0, 1)", 'UPPER'). "='{$this->initial}'", Criteria::CUSTOM);
            }
            $c->addAscendingOrderByColumn(B2bLeadI18nPeer::NAME, myTools::NLSFunc(B2bLeadI18nPeer::NAME, 'SORT'));
        }

        if ($this->category)
        {
            $this->getResponse()->setTitle($i18n->__($this->buying ? 'Buying Leads in %1 Category' : 'Selling Leads in %1 Category', array('%1' => $this->category)). ' | eMarketTurkey');
            $this->mod = 1;
            $c->add(B2bLeadPeer::CATEGORY_ID, $this->category->getId());
        }

        if ($this->country)
        {
            $this->getResponse()->setTitle($i18n->__($this->buying ? 'Buying Leads from %1' : 'Selling Leads from %1', array('%1' => $this->country->getName())). ' | eMarketTurkey');
            $this->mod = 2;
            $c->addJoin(B2bLeadPeer::COMPANY_ID, CompanyPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(CompanyPeer::PROFILE_ID, CompanyProfilePeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(CompanyProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->add(ContactAddressPeer::COUNTRY, "UPPER(".ContactAddressPeer::COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);
        }
        
        if ($this->mod === null) $this->redirect($this->buying ? "@buying-leads" : "selling-leads");
        
        $c->setDistinct();
        
        $pager = new sfPropelPager('B2bLead', 20);
        $pager->setPage($this->page);
        $pager->setCriteria($c);
        $pager->init();
        $this->pager = $pager;
    }

    public function handleError()
    {
    }

}
