<?php

class listAction extends EmtManageGroupAction
{
    protected $actionID = ActionPeer::ACT_MANAGE_MEMBERS;
    
    public function execute($request)
    {
        $this->ipps = array('extended'  => array(10, 20, 50),
                            'list'      => array(10, 20, 50, 100),
                            'thumbs'    => array(20, 50, 100, 150)
                        );
        
        $this->types = array('user'  => PrivacyNodeTypePeer::PR_NTYP_USER,
                             'company'  => PrivacyNodeTypePeer::PR_NTYP_COMPANY
                        );
        
        $this->keyword = $this->getRequestParameter('mkeyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->status = myTools::pick_from_list($this->getRequestParameter('status'), array(GroupMembershipPeer::STYP_ACTIVE), GroupMembershipPeer::STYP_ACTIVE);
        $this->view = myTools::pick_from_list($this->getRequestParameter('view'), array('extended', 'list', 'thumbs'), 'list');
        $this->ipp = myTools::pick_from_list($this->getRequestParameter('ipp'), $this->ipps[$this->view], 20);
        
        $this->type = myTools::pick_from_list($this->getRequestParameter('typ'), array_keys($this->types), 'user');
        $this->type_id = $this->types[$this->type];
        $this->gender = myTools::pick_from_list($this->getRequestParameter('gn'), array(UserProfilePeer::GENDER_FEMALE, UserProfilePeer::GENDER_MALE), null);
        $this->sector = BusinessSectorPeer::retrieveByPK(myTools::fixInt($this->getRequestParameter('sct'), 0));

        $c = new Criteria();
        if ($this->type_id == PrivacyNodeTypePeer::PR_NTYP_USER)
        {
            $c->addJoin(GroupMembershipPeer::OBJECT_ID, UserPeer::ID, Criteria::LEFT_JOIN);
            $c->add(GroupMembershipPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_USER);
            $c->addAscendingOrderByColumn("NLSSORT(EMT_USER.NAME,'NLS_SORT=GENERIC_M_CI'), NLSSORT(EMT_USER.LASTNAME,'NLS_SORT=GENERIC_M_CI')");
            if ($this->keyword)
            {
                $c->add(UserPeer::NAME, "UPPER(EMT_USER.NAME || ' ' || EMT_USER.LASTNAME) LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            }
            if ($this->gender)
            {
                $c->add(UserPeer::GENDER, $this->gender);
            }
        }
        elseif ($this->type_id == PrivacyNodeTypePeer::PR_NTYP_COMPANY)
        {
            $c->addJoin(GroupMembershipPeer::OBJECT_ID, CompanyPeer::ID, Criteria::LEFT_JOIN);
            $c->add(GroupMembershipPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_COMPANY);
            $c->addAscendingOrderByColumn("NLSSORT(EMT_COMPANY.NAME,'NLS_SORT=GENERIC_M_CI')");
            if ($this->keyword)
            {
                $c->add(CompanyPeer::NAME, "UPPER(EMT_COMPANY.NAME) LIKE UPPER('%{$this->keyword}%')", Criteria::CUSTOM);
            }
            if ($this->sector)
            {
                $c->add(CompanyPeer::SECTOR_ID, $this->sector->getId());
            }
        }

        $this->pager = $this->group->getMemberPager($this->page, $this->ipp, $c, $this->status, $this->type_id);

    }
    
    public function handleError()
    {
    }
    
}
