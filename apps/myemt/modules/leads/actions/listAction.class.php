<?php

class listAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        $this->ipps = array(10, 20, 50, 100);
        
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->type = myTools::pick_from_list($this->getRequestParameter('type'), array(B2bLeadPeer::B2B_LEAD_BUYING, B2bLeadPeer::B2B_LEAD_SELLING), B2bLeadPeer::B2B_LEAD_BUYING);
        $this->view = myTools::pick_from_list($this->getRequestParameter('view'), array('extended', 'list'), 'list');
        $this->ipp = myTools::pick_from_list($this->getRequestParameter('ipp'), $this->ipps, 20);
        
        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(B2bLeadPeer::ID, B2bLeadI18nPeer::ID);
            $c->add(B2bLeadI18nPeer::NAME, "UPPER(".B2bLeadI18nPeer::NAME.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
            $c->addOr(B2bLeadI18nPeer::DESCRIPTION, "UPPER(".B2bLeadI18nPeer::DESCRIPTION.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
        }
        
        $this->pager = $this->company->getLeadPager($this->page, $this->ipp, $c, $this->type);
    }
    
    public function handleError()
    {
    }
    
}
