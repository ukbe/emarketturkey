<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class indexAction extends EmtAction
{
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->ipps = array('extended'  => array(10, 20, 50),
                            'list'      => array(10, 20, 50, 100),
                            'thumbs'    => array(10, 20, 40, 60)
                        );
        $roles = array(
                     'friend'       => RolePeer::RL_NETWORK_MEMBER,
                     'group'        => RolePeer::RL_GP_MEMBER,
                     'following'    => RolePeer::RL_CM_FOLLOWER
        );

        $objtypes = array(
                     'friend'       => PrivacyNodeTypePeer::PR_NTYP_USER,
                     'group'        => PrivacyNodeTypePeer::PR_NTYP_GROUP,
                     'following'    => PrivacyNodeTypePeer::PR_NTYP_COMPANY
        );
        
        $this->labels = array(
                     'friend'       => 'Friends',
                     'group'        => 'Groups',
                     'following'    => 'Companies'
        );
        
        
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->view = 'extended';
        $this->ipp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ipp')), $this->ipps[$this->view], 10);
        $this->role_name = myTools::pick_from_list($this->getRequestParameter('relation'), array_keys($roles), 'friend');
        $this->role = $this->role_name ? RolePeer::retrieveByPK($roles[$this->role_name]) : null;

        $this->partial_name = $objtypes[$this->role_name] == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? 'company' : ($this->role_name == 'group' ? 'group' : 'user');
        
        $this->pager = $this->sesuser->getConnections($objtypes[$this->role_name], $roles[$this->role_name], true, true, null, false, 20, $this->page);
    }

    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;

    }
}