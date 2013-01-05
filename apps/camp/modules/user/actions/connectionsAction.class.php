<?php

class connectionsAction extends EmtUserAction
{

    public function execute($request)
    {
        if (!$this->thisIsMe &&
            !($this->sesuser->can(ActionPeer::ACT_VIEW_FRIENDS, $this->user)
              || $this->sesuser->can(ActionPeer::ACT_VIEW_GROUPS, $this->user)
              || $this->sesuser->can(ActionPeer::ACT_VIEW_FOLLOWS, $this->user)
             )
           )
        {
            $this->redirect($this->user->getProfileUrl(), 401);
        }

        $this->getResponse()->setTitle($this->user . ' | eMarketTurkey');

        $this->num_common_friends = $this->user->getId() != $this->sesuser->getId() ? $this->sesuser->getCommonFriends($this->user->getId(), null, false, true) : 0;
        $this->common_friends = $this->user->getId() != $this->sesuser->getId() ? $this->sesuser->getCommonFriends($this->user->getId(), null, true, false, 1, 5, false) : array();

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
        
        
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->view = 'extended';
        $this->ipp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ipp')), $this->ipps[$this->view], 10);
        $this->role_name = myTools::pick_from_list($this->getRequestParameter('relation'), array_keys($roles), 'friend');
        $this->role = $this->role_name ? RolePeer::retrieveByPK($roles[$this->role_name]) : null;

        $this->partial_name = $objtypes[$this->role_name] == PrivacyNodeTypePeer::PR_NTYP_COMPANY ? 'company' : ($this->role_name == 'group' ? 'group' : 'user');
        
        $this->pager = $this->user->getConnections($objtypes[$this->role_name], $roles[$this->role_name], true, true, null, false, 20, $this->page);
        
        if (!$this->thisIsMe) RatingPeer::logNewVisit($this->user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER);
    }

}