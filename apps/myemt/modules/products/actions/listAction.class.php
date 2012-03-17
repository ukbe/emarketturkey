<?php

class listAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        $this->ipps = array('extended'  => array(10, 20, 50),
                            'list'      => array(10, 20, 50, 100),
                            'thumbs'    => array(20, 50, 100, 150)
                        );
        
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->status = myTools::pick_from_list($this->getRequestParameter('status'), array(ProductPeer::PR_STAT_APPROVED, ProductPeer::PR_STAT_EDITING_REQUIRED, ProductPeer::PR_STAT_PENDING_APPROVAL), ProductPeer::PR_STAT_APPROVED);
        $this->view = myTools::pick_from_list($this->getRequestParameter('view'), array('extended', 'list', 'thumbs'), 'list');
        $this->ipp = myTools::pick_from_list($this->getRequestParameter('ipp'), $this->ipps[$this->view], 20);
        $this->group = is_numeric($this->getRequestParameter('group')) ? $this->company->getProductGroupById($this->getRequestParameter('group')) : null;
        $this->category = is_numeric($this->getRequestParameter('category')) ? $this->company->getProductCategory($this->getRequestParameter('category')) : null;

        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(ProductPeer::ID, ProductI18nPeer::ID);
            $c->add(ProductI18nPeer::NAME, "UPPER(".ProductI18nPeer::NAME.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
            $c->addOr(ProductI18nPeer::INTRODUCTION, "UPPER(".ProductI18nPeer::INTRODUCTION.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
            $c->addOr(ProductI18nPeer::PACKAGING, "UPPER(".ProductI18nPeer::PACKAGING.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
        }
        
        if ($this->category)
        {
            $c->add(ProductPeer::CATEGORY_ID, $this->category->getId());
        }
        
        if ($this->group)
        {
            $c->add(ProductPeer::GROUP_ID, $this->group->getId());
        }
        
        $this->pager = $this->company->getProductPager($this->page, $this->ipp, $c, $this->status);

    }

    public function handleError()
    {
    }

}
