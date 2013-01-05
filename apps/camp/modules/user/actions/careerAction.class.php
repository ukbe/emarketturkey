<?php

class careerAction extends EmtUserAction
{

    public function execute($request)
    {
        if ($this->user->getId() != $this->sesuser->getId() &&
            !$this->sesuser->can(ActionPeer::ACT_VIEW_CAREER, $this->user))
        {
            $this->redirect($this->user->getProfileUrl(), 401);
        }

        $this->getResponse()->setTitle($this->user . ' | eMarketTurkey');

        $criterias = array('wheres' => array("(P_OBJECT_TYPE_ID={$this->user->getObjectTypeId()} AND P_OBJECT_ID={$this->user->getId()})"));

        $this->num_common_friends = $this->user->getId() != $this->sesuser->getId() ? $this->sesuser->getCommonFriends($this->user->getId(), null, false, true) : 0;
        $this->common_friends = $this->user->getId() != $this->sesuser->getId() ? $this->sesuser->getCommonFriends($this->user->getId(), null, true, false, 1, 5, false) : array();
        $this->num_groups = $this->sesuser->getGroupMemberships(RolePeer::RL_GP_MEMBER, GroupMembershipPeer::STYP_ACTIVE, false, null, false, true);
        $this->groups = $this->sesuser->getGroupMemberships(RolePeer::RL_GP_MEMBER, GroupMembershipPeer::STYP_ACTIVE, true, null, true, false, 1, 5, false);

        $this->occupations = $this->user->getWorkHistory(false);
        $this->educations = $this->user->getEducationHistory(false);
        
        if (!$this->thisIsMe) RatingPeer::logNewVisit($this->user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER);
    }

}