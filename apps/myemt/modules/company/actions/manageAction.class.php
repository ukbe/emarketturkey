<?php

class manageAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        $this->profile = $this->company->getCompanyProfile();
        $this->num_followers = $this->company->countFollowers();
        if ($this->profile) $this->contact = $this->profile->getContact();
        if ($this->contact)
        {
            $this->work_address = $this->contact->getWorkAddress();
            $this->work_phone = $this->contact->getWorkPhone(); 
        }
        
        if (!$this->work_address) $this->work_address = new ContactAddress();
        if (!$this->work_phone) $this->work_phone = new ContactPhone();
        
        $c = new Criteria();
        $c->add(MessageRecipientPeer::IS_READ, 0);
        $this->num_messages = $this->company->countMessages($c);

        $this->tips = array();
        $this->tips['Upload Company Logo'] = array('company/logo', 'Company does not have a logo.');
        $this->tips['Add New Products or Services'] = array('products/new', 'Company does not have any products or services.');
        
        $c = new Criteria();
        $c->addJoin(ProductPeer::ID, MediaItemPeer::OWNER_ID);
        $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_PRODUCT);
        $c->setLimit(5);
        $this->tmpproducts = ProductPeer::doSelect($c);
    }
    
    public function handleError()
    {
    }
    
}
