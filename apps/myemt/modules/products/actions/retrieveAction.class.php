<?php

class retrieveAction extends EmtAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();
        $this->company = CompanyPeer::getCompanyFromUrl($this->getRequest()->getParameterHolder());
        
        if (!$this->company)
        {
            $this->redirect('@homepage');
        }
        
        $this->filter = $this->getRequestParameter('filter');
        
        $c = new Criteria();
        $c->addJoin(ProductPeer::ID, ProductI18nPeer::ID, Criteria::LEFT_JOIN);
        $c->addJoin(ProductPeer::CATEGORY_ID, ProductCategoryI18nPeer::ID, Criteria::LEFT_JOIN);
        ProductPeer::addSelectColumns($c);
        
        if ($this->filter!=='')
        {
            $c1 = $c->getNewCriterion(ProductI18nPeer::DISPLAY_NAME, "UPPER(".ProductI18nPeer::DISPLAY_NAME.") LIKE UPPER('%{$this->filter}%')", Criteria::CUSTOM);
            $c2 = $c->getNewCriterion(ProductPeer::MODEL_NO, "UPPER(".ProductPeer::MODEL_NO.") LIKE UPPER('%{$this->filter}%')", Criteria::CUSTOM);
            $c1->addOr($c2);
            $c->add($c1);
        }
        $c->setDistinct();

        $columns = array('model' => ProductPeer::MODEL_NO,
                         'name' => ProductPeer::NAME,
                         'category' => ProductCategoryI18nPeer::NAME
                   );
        $this->sort = array_key_exists(strtolower($this->getRequestParameter('sort')), $columns) ? strtolower($this->getRequestParameter('sort')) : 'name';
        
        $this->dir = strtoupper($this->getRequestParameter('dir')) == 'ASC' ? 'ASC' : 'DESC';

        if ($this->dir == 'ASC')
            $c->addAscendingOrderByColumn($columns[$this->sort]);
        else
            $c->addDescendingOrderByColumn($columns[$this->sort]);

        $cat = $this->company->getProductCategory($this->getRequestParameter('cat'));
        if ($cat)
        {
            $c->addAnd(ProductPeer::CATEGORY_ID, $cat->getId());
        }
        $this->cat = $cat?$cat->getId():null;
        
        $c->add(ProductPeer::COMPANY_ID, $this->company->getId());
        
        $this->categories = $this->company->getProductCategories();
        
        $this->max = $this->getRequestParameter('max', 10);
        $this->start = $this->getRequestParameter('st', 0);

        $this->pager = new sfPropelPager('Product', $this->max);
        $this->pager->setCriteria($c);
        $this->pager->setPage(ceil(($this->start/$this->max)));
        $this->pager->init();
        $this->pagenum = $this->pager->getPage();
        $this->products = $this->pager->getResults();
        
    }
    
    public function handleError()
    {
    }
    
}
