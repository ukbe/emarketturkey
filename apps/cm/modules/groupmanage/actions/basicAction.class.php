<?php

class basicAction extends EmtGroupAction
{
    protected $actionID = ActionPeer::ACT_UPDATE_CORPORATE_INFO;
      
    public function handleAction($isValidationError)
    {
        if (!$this->goodToRun) $this->redirect404();
        
        $this->contact = $this->group->getContact();
        
        if ($this->contact)
        {
            $this->work_address = $this->contact->getWorkAddress();
            $this->work_phone = $this->contact->getWorkPhone(); 
        }
        
        if (!$this->work_address) $this->work_address = new ContactAddress();
        if (!$this->work_phone) $this->work_phone = new ContactPhone();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(CompanyPeer::DATABASE_NAME);
    
            try
            {
                $con->beginTransaction();
                
                $this->group->setName($this->getRequestParameter('group_name'));
                $this->group->setTypeId($this->getRequestParameter('group_type_id'));
                $this->group->setFoundedIn(mktime(0, 0, 0, 1, 1, $this->getRequestParameter('group_founded_in')));
                $this->group->setUrl($this->getRequestParameter('group_url'));
                $this->group->save();
                
                $pr = $this->getRequestParameter('languages');
                
                if (is_array($pr))
                {
                    foreach($pr as $lang)
                    {
                        $ci18n = $this->group->getCurrentGroupI18n($lang);
                        $ci18n->setDisplayName($this->getRequestParameter('group_displayname_'.$lang));
                        if ($this->group->getTypeId()!=GroupTypePeer::GRTYP_ONLINE)
                            $ci18n->setAbbreviation($this->getRequestParameter('group_abbreviation_'.$lang));
                        else
                            $ci18n->setAbbreviation('');
                        $ci18n->setIntroduction($this->getRequestParameter('group_introduction_'.$lang));
                        $ci18n->setMemberProfile($this->getRequestParameter('group_member_profile_'.$lang));
                        $ci18n->setEventsIntroduction($this->getRequestParameter('group_events_'.$lang));
                        $ci18n->save();
                    }
                }
                
                $this->group->save();
                
                ActionLogPeer::Log($this->group, ActionPeer::ACT_UPDATE_GROUP_INFO);
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Group information has been saved successfully.', null, null, true);
                $this->redirect('@group-manage?action=edit&stripped_name='.$this->group->getStrippedName());
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing group information. Please try again later.', null, null, false);
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}