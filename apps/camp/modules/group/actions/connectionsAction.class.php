<?php

class connectionsAction extends EmtGroupAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle($this->group . ' | eMarketTurkey');

        $this->ipps = array('extended'  => array(10, 20, 50),
                            'list'      => array(10, 20, 50, 100),
                            'thumbs'    => array(10, 20, 40, 60)
                        );
        $roles = array(
                     'linked'       => RolePeer::RL_GP_LINKED_GROUP,
                     'companies'    => RolePeer::RL_MEMBERED_GROUP,
                     'people'       => RolePeer::RL_MEMBERED_GROUP,
        );
        
        $objtypes = array(
                     'linked'       => PrivacyNodeTypePeer::PR_NTYP_GROUP,
                     'companies'    => PrivacyNodeTypePeer::PR_NTYP_COMPANY,
                     'people'       => PrivacyNodeTypePeer::PR_NTYP_USER,
        );
        
        
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->view = 'extended';
        $this->ipp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ipp')), $this->ipps[$this->view], 10);
        $this->role_name = myTools::pick_from_list($this->getRequestParameter('relation'), array_keys($roles), 'linked');
        $this->role = $this->role_name ? RolePeer::retrieveByPK($roles[$this->role_name]) : null;

        $this->partial_name = $objtypes[$this->role_name] == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? 'company' : ($this->role_name == 'linked' ? 'group' : 'user');
        
        $this->pager = $this->group->getConnections($objtypes[$this->role_name], $roles[$this->role_name], true, true, null, false, $this->ipp, $this->page);

        
        if (!$this->own_group) RatingPeer::logNewVisit($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP);
    }
    
    public function handleError()
    {
    }
    
}
