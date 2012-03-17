<?php

class infoAction extends EmtGroupAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle($this->group . ' | eMarketTurkey');

        $this->posts = $this->group->getPosts();
        $this->top_discussions = $this->group->getTopDiscussions(8);
        $this->events = array();
        $this->parent_groups = $this->group->getLinkedGroups(null, RolePeer::RL_GP_PARENT_GROUP, GroupMembershipPeer::STYP_ACTIVE);
        $this->sub_groups = $this->group->getLinkedGroups(null, RolePeer::RL_GP_SUBSIDIARY_GROUP, GroupMembershipPeer::STYP_ACTIVE);
        $this->photos = $this->group->getMediaItems(MediaItemPeer::MI_TYP_ALBUM_PHOTO, null, true, false, 1, 4, false);
        
        $this->profile_image = count($imgs = $this->group->getMediaItems(MediaItemPeer::MI_TYP_BANNER_IMAGE)) ? $imgs[0] : null;

        if (!$this->own_group) RatingPeer::logNewVisit($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP);
    }

    public function handleError()
    {
    }

}
