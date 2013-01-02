<?php

class leadsAction extends EmtCompanyAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle($this->company->getName() . ' | eMarketTurkey');

        $this->groups = $this->company->getOrderedGroups(false);

        $this->ipps = array('extended'  => array(10, 20, 50),
                            'list'      => array(10, 20, 50, 100),
                            'thumbs'    => array(10, 20, 40, 60)
                        );

        $types = array(
             'selling'  => B2bLeadPeer::B2B_LEAD_SELLING,
             'buying'   => B2bLeadPeer::B2B_LEAD_BUYING
        );

        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->view = myTools::pick_from_list($this->getRequestParameter('view'), array('extended', 'list', 'thumbs'), 'thumbs');
        $this->ipp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ipp')), $this->ipps[$this->view], 10);
        $this->role_name = myTools::pick_from_list($this->getRequestParameter('type'), array_keys($types), null);
        $this->type = myTools::pick_from_list($this->getRequestParameter('type'), array_keys($types), null);
        $this->type_id = $this->type ? $types[$this->type] : null;
        
        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(B2bLeadPeer::ID, B2bLeadI18nPeer::ID);
            $c->add(B2bLeadI18nPeer::NAME, myTools::NLSFunc(B2bLeadI18nPeer::NAME, 'UPPER') . ' LIKE ' . myTools::NLSFunc("%{$this->keyword}%"), Criteria::CUSTOM);
            $c->addOr(B2bLeadI18nPeer::DESCRIPTION, myTools::NLSFunc(B2bLeadI18nPeer::DESCRIPTION, 'UPPER') . " LIKE ". myTools::NLSFunc("%{$this->keyword}%", 'UPPER'), Criteria::CUSTOM);
        }
        
        $this->pager = $this->company->getLeadPager($this->page, $this->ipp, $c, $this->type_id);
        
        if (!$this->own_company) RatingPeer::logNewVisit($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY);
    }
    
    public function handleError()
    {
    }
    
}
