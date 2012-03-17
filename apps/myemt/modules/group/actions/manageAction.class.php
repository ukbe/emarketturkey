<?php

class manageAction extends EmtManageGroupAction
{
    protected $actionID = ActionPeer::ACT_MANAGE_GROUP;

    public function execute($request)
    {
        if (!$this->goodToRun) $this->redirect404();
        
        $this->people = $this->group->getPeople();
        $this->contact = $this->group->getContact();
        if ($this->contact)
        {
            $this->work_address = $this->contact->getWorkAddress();
            $this->work_phone = $this->contact->getWorkPhone(); 
        }
        
        if (!$this->work_address) $this->work_address = new ContactAddress();
        if (!$this->work_phone) $this->work_phone = new ContactPhone();
        
        //$c = new Criteria();
        //$c->add(MessageRecipientPeer::IS_READ, 0);
        //$this->messages = $this->group->getMessages($c);

        $this->tips = array();
        if (!$this->group->getLogo()) $this->tips['Upload Group Logo'] = array('group/logo?id='.$this->group->getId(), 'Group does not have a logo.');
        $c = new Criteria();
        $c->add(GroupMembershipPeer::STATUS, GroupMembershipPeer::STYP_ACTIVE);
        $c->add(GroupMembershipPeer::ROLE_ID, RolePeer::RL_GP_OWNER, Criteria::NOT_EQUAL);
        if (!$this->group->countGroupMemberships($c)) $this->tips['Invite People to Group'] = array('@group-manage?action=invite&stripped_name='.$this->group->getStrippedName(), 'Group does not have any members.');
    }
    
    public function handleError()
    {
    }
    
}
