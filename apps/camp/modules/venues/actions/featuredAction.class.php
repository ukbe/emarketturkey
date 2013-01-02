<?php

class featuredAction extends EmtAction
{
    public function execute($request)
    {
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->country = preg_match("/^[A-Za-z]{2}$/", $this->getRequestParameter('country')) ? strtoupper($this->getRequestParameter('country')) : '';
        $c = new Criteria();
        
        if ($this->keyword)
        {
            $c->addJoin(PlacePeer::ID, PlaceI18nPeer::ID, Criteria::LEFT_JOIN);
            $c->add(PlaceI18nPeer::NAME, "UPPER(".PlaceI18nPeer::NAME.") LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
        }

        if ($this->country)
        {
            $c->add(PlacePeer::COUNTRY, "UPPER(".PlacePeer::COUNTRY.") = '{$this->country}'", Criteria::CUSTOM);
        }
        
        $c->add(PlacePeer::IS_FEATURED, 1);

        $c->setDistinct();

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
