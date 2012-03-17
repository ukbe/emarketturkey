<?php

class featuredAction extends EmtAction
{
    public function execute($request)
    {
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->industry = is_numeric($this->getRequestParameter('industry')) ? BusinessSectorPeer::retrieveByPK($this->getRequestParameter('industry')) : null;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('country')) : '';
        $c = new Criteria();
        if ($this->keyword)
        {
            $c1 = $c->getNewCriterion(CompanyPeer::NAME, "UPPER(".CompanyPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c->addJoin(CompanyPeer::PROFILE_ID, CompanyProfilePeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(CompanyProfilePeer::ID, CompanyProfileI18nPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(CompanyProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactAddressPeer::COUNTRY, GeonameCountryPeer::CURRENCY_CODE, Criteria::LEFT_JOIN);
            $c2 = $c->getNewCriterion(CompanyProfilePeer::CERTIFICATIONS, "UPPER(".CompanyProfilePeer::CERTIFICATIONS.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c3 = $c->getNewCriterion(CompanyProfileI18nPeer::INTRODUCTION, "UPPER(".CompanyProfileI18nPeer::INTRODUCTION.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c4 = $c->getNewCriterion(CompanyProfileI18nPeer::PRODUCT_SERVICE, "UPPER(".CompanyProfileI18nPeer::PRODUCT_SERVICE.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c5 = $c->getNewCriterion(GeonameCountryPeer::COUNTRY, "UPPER(".GeonameCountryPeer::COUNTRY.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c1->addOr($c3);
            $c1->addOr($c4);
            $c1->addOr($c5);
            $c->add($c1);
        }

        if ($this->industry)
        {
            $c->add(CompanyPeer::SECTOR_ID, $this->industry->getId());
        }

        if ($this->country)
        {
            $c->addJoin(CompanyPeer::PROFILE_ID, CompanyProfilePeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(CompanyProfilePeer::CONTACT_ID, ContactPeer::ID, Criteria::LEFT_JOIN);
            $c->addJoin(ContactPeer::ID, ContactAddressPeer::CONTACT_ID, Criteria::LEFT_JOIN);
            $c->add(ContactAddressPeer::COUNTRY, "UPPER(".ContactAddressPeer::COUNTRY.") = '{$this->country}'", Criteria::CUSTOM);
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
