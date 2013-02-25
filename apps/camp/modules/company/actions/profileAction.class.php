<?php

class profileAction extends EmtCompanyAction
{
    public function execute($request)
    {
        $this->getResponse()->setTitle($this->company->getName() . ' | eMarketTurkey');

        $this->status_posts = $this->company->getStatusUpdates();
        $this->top_products = $this->company->getTopProducts(8);
        $this->events = array();
        $this->group_mems = $this->company->getGroupMemberships(RolePeer::RL_GP_MEMBER, GroupMembershipPeer::STYP_ACTIVE);
        $this->profile_photos = $this->company->getMediaItems(MediaItemPeer::MI_TYP_ALBUM_PHOTO);
        $this->partners = $this->company->getPartners(null, null, array(CompanyUserPeer::CU_STAT_ACTIVE));
        $contact = $this->company->getContact();
        $address = $contact->getWorkAddress();
        $phone = $contact->getWorkPhone();
        $fax_number = $contact->getPhoneByType(ContactPeer::FAX);

        $this->profile_image = count($imgs = $this->company->getMediaItems(MediaItemPeer::MI_TYP_BANNER_IMAGE)) ? $imgs[0] : null;

        $this->getResponse()->setItemType('http://schema.org/Organization');
        
        $this->getResponse()->addObjectMeta(array('name' => 'description', 'itemprop' => 'description'), myTools::trim_text($this->profile->getClob(CompanyProfileI18nPeer::INTRODUCTION), 250, true));
        $this->getResponse()->addObjectMeta(array('name' => 'name', 'itemprop' => 'name'), $this->company->__toString());
        $this->getResponse()->addObjectMeta(array('itemprop' => 'brand'), implode(', ', $this->company->getCompanyBrands()));
        $this->getResponse()->addObjectMeta(array('itemprop' => 'foundingDate'), $this->profile->getFoundedIn('Y'));
        if ($address) $this->getResponse()->addObjectMeta(array('itemprop' => 'address'), $address->__toString());
        if ($phone) $this->getResponse()->addObjectMeta(array('itemprop' => 'telephone'), $phone->__toString());
        if ($fax_number) $this->getResponse()->addObjectMeta(array('itemprop' => 'faxNumber'), $fax_number->__toString());
        $this->getResponse()->addObjectMeta(array('http-equiv' => 'last-modified'), $this->company->getUpdatedAt('Y-m-d\TH:i:s\Z'));
        sfLoader::loadHelpers('Url');
        $this->getResponse()->addObjectMeta(array('itemprop' => 'url'), url_for($this->company->getProfileUrl(), true));
        if ($this->company->getLogo())
        {
            $this->getResponse()->addObjectMeta(array('itemprop' => 'image'), url_for($this->company->getLogo()->getThumbnailUri(), true));
            $this->getResponse()->addObjectMeta(array('itemprop' => 'logo'), url_for($this->company->getLogo()->getThumbnailUri(), true));
        }

        if (!$this->own_company) RatingPeer::logNewVisit($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY);
    }

    public function handleError()
    {
    }

}
