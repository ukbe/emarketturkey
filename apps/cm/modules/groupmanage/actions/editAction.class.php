<?php

class editAction extends EmtGroupAction
{
    protected $actionID = ActionPeer::ACT_UPDATE_CORPORATE_INFO;
      
    public function execute($request)
    {
        if (!$this->goodToRun) $this->redirect404();
        
        $this->contact = $this->group->getContact();
        if ($this->contact)
        {
            $this->work_address = $this->contact->getWorkAddress();
            $this->work_phone = $this->contact->getWorkPhone(); 
            $this->fax_number = $this->contact->getPhoneByType(ContactPeer::FAX);
        }
        
        if (!$this->work_address) $this->work_address = new ContactAddress();
        if (!$this->work_phone) $this->work_phone = new ContactPhone();
        if (!$this->fax_number) $this->fax_number = new ContactPhone();
    }
    
    public function handleError()
    {
    }
    
}