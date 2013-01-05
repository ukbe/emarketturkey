<?php

class connectionsAction extends EmtCompanyAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.company-profile-action?".http_build_query($params), 301);

        $this->getResponse()->setTitle($this->company->getName() . ' | eMarketTurkey');

        $this->ipps = array('extended'  => array(10, 20, 50),
                            'list'      => array(10, 20, 50, 100),
                            'thumbs'    => array(10, 20, 40, 60)
                        );
        $roles = array(
                     'parent'       => RolePeer::RL_CM_PARENT_COMPANY,
                     'subsidiary'   => RolePeer::RL_CM_SUBSIDIARY_COMPANY,
                     'partner'      => RolePeer::RL_CM_PARTNER,
                     'follower'     => RolePeer::RL_FOLLOWED_COMPANY,
                     'group'        => RolePeer::RL_GP_MEMBER
        );
        
        $objtypes = array(
                     'parent'       => PrivacyNodeTypePeer::PR_NTYP_COMPANY,
                     'subsidiary'   => PrivacyNodeTypePeer::PR_NTYP_COMPANY,
                     'partner'      => PrivacyNodeTypePeer::PR_NTYP_COMPANY,
                     'follower'     => PrivacyNodeTypePeer::PR_NTYP_USER,
                     'group'        => PrivacyNodeTypePeer::PR_NTYP_GROUP
        );
        
        
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->view = 'extended';
        $this->ipp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ipp')), $this->ipps[$this->view], 10);
        $this->role_name = myTools::pick_from_list($this->getRequestParameter('relation'), array_keys($roles), 'partner');
        $this->role = $this->role_name ? RolePeer::retrieveByPK($roles[$this->role_name]) : null;

        $this->partial_name = $objtypes[$this->role_name] == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? 'company' : ($this->role_name == 'group' ? 'group' : 'user');
        
        $this->pager = $this->company->getConnections($objtypes[$this->role_name], $roles[$this->role_name], true, true, null, false, $this->ipp, $this->page);

        
        if (!$this->own_company) RatingPeer::logNewVisit($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY);
    }
    
    public function handleError()
    {
    }
    
}
