<?php

class productsAction extends EmtCompanyAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle($this->company->getName() . ' | eMarketTurkey');

        $this->groups = $this->company->getOrderedGroups(false);
        $this->categories = $this->company->getOrderedCategories(false);

        $this->ipps = array('extended'  => array(10, 20, 50),
                            'list'      => array(10, 20, 50, 100),
                            'thumbs'    => array(10, 20, 40, 60)
                        );
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->view = myTools::pick_from_list($this->getRequestParameter('view'), array('extended', 'list', 'thumbs'), 'thumbs');
        $this->ipp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ipp')), $this->ipps[$this->view], 10);
        $this->group = $this->getRequestParameter('substitute') ? $this->company->getProductGroupByStrippedName($this->getRequestParameter('substitute')) : null;
        $this->category = $this->getRequestParameter('substitute') ? ProductCategoryPeer::retrieveByStrippedCategory($this->getRequestParameter('substitute')) : null;

        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(ProductPeer::ID, ProductI18nPeer::ID);
            $c->add(ProductI18nPeer::NAME, "UPPER(".ProductI18nPeer::NAME.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
            $c->addOr(ProductI18nPeer::INTRODUCTION, "UPPER(".ProductI18nPeer::INTRODUCTION.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
            $c->addOr(ProductI18nPeer::PACKAGING, "UPPER(".ProductI18nPeer::PACKAGING.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
        }
        
        if ($this->group)
        {
            $c->add(ProductPeer::GROUP_ID, $this->group->getId());
        }
        else
        {
            $c->add(ProductPeer::GROUP_ID, null, Criteria::ISNULL);
        }
        if (!$this->group && $this->category)
        {
            $c->add(ProductPeer::CATEGORY_ID, $this->category->getId());
        }
        
        $c->add(ProductPeer::ACTIVE, 1);
        
        $this->pager = $this->company->getProductPager($this->page, $this->ipp, $c, ProductPeer::PR_STAT_APPROVED);
        
        if (!$this->own_company) RatingPeer::logNewVisit($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY);
    }
    
    public function handleError()
    {
    }
    
}
