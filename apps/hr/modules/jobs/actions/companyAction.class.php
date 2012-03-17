<?php

class companyAction extends EmtCompanyAction
{
    public function execute($request)
    {
        $act = myTools::pick_from_list($this->getRequestParameter('act'), array('save', 'rem', 'ban', 'unb'), null);
        if ($act)
        {
            if ($this->sesuser->isNew())
            {
                $this->redirect('@myemt.login?_ref='.$this->_here);
            }

            $fav = $this->sesuser->getUserCompany($this->company->getId(), UserBookmarkPeer::BMTYP_FAVOURITE);
            $ban = $this->sesuser->getUserCompany($this->company->getId(), UserBookmarkPeer::BMTYP_BANNED);
            if ($act == 'rem' && $fav)
            {
                $fav->delete();
                $this->getUser()->setAttribute('act', array('rem', $this->company->getHash()), '/hr/companies');
            }
            if ($act == 'unb' && $ban)
            {
                $ban->delete();
                $this->getUser()->setAttribute('act', array('unb', $this->company->getHash()), '/hr/companies');
            }
            if (($act == 'save' && !$fav) || ($act == 'ban' && !$ban))
            {
                $usercomp = new UserBookmark();
                $usercomp->setUserId($this->sesuser->getId());
                $usercomp->setItemId($this->company->getId());
                $usercomp->setItemTypeId(PrivacyNodeTypePeer::PR_NTYP_COMPANY);
                $usercomp->setTypeId($act == 'save' ? UserBookmarkPeer::BMTYP_FAVOURITE : UserBookmarkPeer::BMTYP_BANNED);
                $usercomp->save();
                $this->getUser()->setAttribute('act', array($act, $this->company->getHash()), '/hr/companies');
            }
            $this->redirect("@company-jobs?hash={$this->company->getHash()}");
        }

        $act = $this->getUser()->getAttribute('act', null, '/hr/companies');
        if ($act && is_array($act) && count($act) == 2 && $act[1] == $this->company->getHash())
        {
            $act = $act[0];
            $this->getUser()->getAttributeHolder()->remove('act', null, '/hr/companies');
            $this->messages = array('save' => 'Company has been successfully added to bookmarks.',
                                    'rem'  => 'Company has been successfully removed from bookmarks.',
                                    'ban'  => 'Company has been successfully blocked.',
                                    'unb'  => 'Company has been successfully unblocked.',
                                );
        }
        else 
        {
            $act = null;
            $this->getUser()->getAttributeHolder()->remove('act', null, '/hr/companies');
        }
        $this->act = $act;
        
        $this->own_company = $this->sesuser->isOwnerOf($this->company);

        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("Company Jobs: %1", array('%1' => $this->company)) . ' | eMarketTurkey');

        $this->hrprofile = $this->company->getHRProfile();

        $this->jobs = $this->company->getOnlineJobs();
    }
    
    public function handleError()
    {
    }
    
}