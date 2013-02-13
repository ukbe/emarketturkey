<?php

class groupAction extends EmtGroupAction
{
    public function execute($request)
    {
        $act = myTools::pick_from_list($this->getRequestParameter('act'), array('save', 'rem', 'ban', 'unb'), null);
        if ($act)
        {
            if ($this->sesuser->isNew())
                $this->redirect("@myemt.login?_ref={$this->_here}");

            $fav = $this->sesuser->getBookmarkByItem($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, UserBookmarkPeer::BMTYP_FAVOURITE);
            $ban = $this->sesuser->getBookmarkByItem($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, UserBookmarkPeer::BMTYP_BANNED);
            if ($act == 'rem' && $fav)
            {
                $fav->delete();
                $this->getUser()->setAttribute('act', array('rem', $this->group->getHash()), '/hr/groups');
            }
            if ($act == 'unb' && $ban)
            {
                $ban->delete();
                $this->getUser()->setAttribute('act', array('ban', $this->group->getHash()), '/hr/groups');
            }
            if (($act == 'save' && !$fav) || ($act == 'ban' && !$ban))
            {
                $usercomp = new UserBookmark();
                $usercomp->setUserId($this->sesuser->getId());
                $usercomp->setItemId($this->group->getId());
                $usercomp->setItemTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
                $usercomp->setTypeId($act == 'save' ? UserBookmarkPeer::BMTYP_FAVOURITE : UserBookmarkPeer::BMTYP_BANNED);
                $usercomp->save();
                $this->getUser()->setAttribute('act', array($act, $this->group->getHash()), '/hr/groups');
            }
            $this->redirect($this->group->getProfileActionUrl('jobs'));
        }

        $act = $this->getUser()->getAttribute('act', null, '/hr/groups');
        if ($act && is_array($act) && count($act) == 2 && $act[1] == $this->group->getHash())
        {
            $act = $act[0];
            $this->getUser()->getAttributeHolder()->remove('act', null, '/hr/groups');
            $this->messages = array('save' => 'Group has been successfully added to bookmarks.',
                                    'rem'  => 'Group has been successfully removed from bookmarks.',
                                    'ban'  => 'Group has been successfully blocked.',
                                    'unb'  => 'Group has been successfully unblocked.',
                                );
        }
        else 
        {
            $act = null;
            $this->getUser()->getAttributeHolder()->remove('act', null, '/hr/groups');
        }
        $this->act = $act;

        $this->own_group = $this->sesuser->isOwnerOf($this->group);

        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("Group Jobs: %1", array('%1' => $this->group)) . ' | eMarketTurkey');

        $this->hrprofile = $this->group->getHRProfile();

        $this->jobs = $this->group->getOnlineJobs();
    }
    
    public function handleError()
    {
    }
    
}