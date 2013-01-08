<?php

class profileAction extends EmtUserAction
{

    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['action']);
        unset($params['sf_culture']);
        $this->redirect("@camp.user-profile?".http_build_query($params), 301);

        if ($this->user->getId() != $this->sesuser->getId() &&
            !$this->sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $this->user))
        {
            if ($this->sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $this->user))
            {
                //$this->setTemplate('publicUserProfile');
            }
            else
            {
                $this->setTemplate('lockedProfile');
            }
        }
        if (!$this->sesuser->can(ActionPeer::ACT_VIEW_PERSONAL_INFO, $this->user))
        {
            $this->setTemplate('protectedContent');
            return sfView::SUCCESS;
        }

        $this->getResponse()->setTitle($this->user . ' | eMarketTurkey');

        $this->posts = $this->user->getPosts();
        $this->photos = $this->user->getMediaItems(MediaItemPeer::MI_TYP_ALBUM_PHOTO, null, true, false, 1, 4, false);
        
        $criterias = array('wheres' => array("(P_OBJECT_TYPE_ID={$this->user->getObjectTypeId()} AND P_OBJECT_ID={$this->user->getId()})"));

        $this->num_common_friends = $this->user->getId() != $this->sesuser->getId() ? $this->sesuser->getCommonFriends($this->user->getId(), null, false, true) : 0;
        $this->common_friends = $this->user->getId() != $this->sesuser->getId() ? $this->sesuser->getCommonFriends($this->user->getId(), null, true, false, 1, 5, false) : array();
        $this->num_groups = $this->user->getGroupMemberships(RolePeer::RL_GP_MEMBER, GroupMembershipPeer::STYP_ACTIVE, false, null, false, true);
        $this->groups = $this->user->getGroupMemberships(RolePeer::RL_GP_MEMBER, GroupMembershipPeer::STYP_ACTIVE, true, null, true, false, 1, 5, false);

        if (!$this->thisIsMe) RatingPeer::logNewVisit($this->user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER);
    }

}