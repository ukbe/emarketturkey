<?php

class directoryAction extends EmtAction
{
    public function execute($request)
    {
        $this->substitute = $this->getRequestParameter('substitute');
        
        $this->initial = $this->country = $this->category = null;
        
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
            $c->addJoin(ProductPeer::ID, ProductI18nPeer::ID, Criteria::INNER_JOIN);
        }

        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(ProductPeer::BRAND_ID, CompanyBrandPeer::ID, Criteria::LEFT_JOIN);
            $c1 = $c->getNewCriterion(ProductPeer::MODEL_NO, "UPPER(".ProductPeer::MODEL_NO.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(ProductPeer::BRAND_NAME, "UPPER(".ProductPeer::BRAND_NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c3 = $c->getNewCriterion(ProductI18nPeer::NAME, "UPPER(".ProductI18nPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c4 = $c->getNewCriterion(ProductI18nPeer::INTRODUCTION, "UPPER(".ProductI18nPeer::INTRODUCTION.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c5 = $c->getNewCriterion(ProductI18nPeer::PACKAGING, "UPPER(".ProductI18nPeer::PACKAGING.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c6 = $c->getNewCriterion(CompanyBrandPeer::NAME, "UPPER(".CompanyBrandPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c1->addOr($c3);
            $c1->addOr($c4);
            $c1->addOr($c5);
            $c1->addOr($c6);
            $c->add($c1);
        }

        $i18n = $this->getContext()->getI18N();

        if ($this->initial)
        {
            $this->getResponse()->setTitle('Products by Name | eMarketTurkey');
            $this->mod = 3;
            if ($this->initial == '@')
            {
                $c->add(ProductI18nPeer::NAME, myTools::NLSFunc("SUBSTR(".ProductI18nPeer::NAME.", 0, 1)", 'UPPER'). " NOT IN ('".implode("','", range('A','Z'))."')", Criteria::CUSTOM);
            }
            else
            {
                $c->add(ProductI18nPeer::NAME, myTools::NLSFunc("SUBSTR(".ProductI18nPeer::NAME.", 0, 1)", 'UPPER'). "='{$this->initial}'", Criteria::CUSTOM);
            }
            $c->addAscendingOrderByColumn(ProductI18nPeer::NAME, myTools::NLSFunc(ProductI18nPeer::NAME, 'SORT'));
        }

        if ($this->category)
        {
            $this->getResponse()->setTitle($i18n->__('Products in %1 Category', array('%1' => $this->category)). ' | eMarketTurkey');
            $this->mod = 1;
            $c->add(ProductPeer::CATEGORY_ID, $this->category->getId());
        }

        if ($this->country)
        {
            $this->getResponse()->setTitle($i18n->__('Products from %1', array('%1' => $this->country->getName())). ' | eMarketTurkey');
            $this->mod = 2;
            $c->addJoin(ProductPeer::COMPANY_ID, CompanyPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(CompanyPeer::PROFILE_ID, CompanyProfilePeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(CompanyProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->add(ContactAddressPeer::COUNTRY, "UPPER(".ContactAddressPeer::COUNTRY.") = UPPER('{$this->country->getIso()}')", Criteria::CUSTOM);
        }
        
        if ($this->mod === null) $this->redirect("@products");
        
        $c->setDistinct();
        
        $pager = new sfPropelPager('Product', 20);
        $pager->setPage($this->page);
        $pager->setCriteria($c);
        $pager->init();
        $this->pager = $pager;
    }

    public function handleError()
    {
    }

}
