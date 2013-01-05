<?php

class profileAction extends EmtCompanyAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.company-profile-action?".http_build_query($params), 301);

        $this->getResponse()->setTitle($this->company->getName() . ' | eMarketTurkey');

        $this->status_posts = $this->company->getStatusUpdates();
        $this->top_products = $this->company->getTopProducts(8);
        $this->events = array();
        $this->group_mems = $this->company->getGroupMemberships(RolePeer::RL_GP_MEMBER, GroupMembershipPeer::STYP_ACTIVE);
        $this->profile_photos = $this->company->getMediaItems(MediaItemPeer::MI_TYP_ALBUM_PHOTO);
        $this->partners = $this->company->getPartners(null, null, array(CompanyUserPeer::CU_STAT_ACTIVE));
        
        $this->profile_image = count($imgs = $this->company->getMediaItems(MediaItemPeer::MI_TYP_BANNER_IMAGE)) ? $imgs[0] : null;

        if (!$this->own_company) RatingPeer::logNewVisit($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY);
    }

    public function handleError()
    {
    }

}
