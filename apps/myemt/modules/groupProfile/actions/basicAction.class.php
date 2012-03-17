<?php

class basicAction extends EmtManageGroupAction
{
    protected $actionID = ActionPeer::ACT_UPDATE_CORPORATE_INFO;
      
    public function handleAction($isValidationError)
    {
        $this->contact = $this->group->getContact();
        
        if ($this->contact)
        {
            $this->work_address = $this->contact->getWorkAddress();
            $this->work_phone = $this->contact->getWorkPhone(); 
        }
        
        if (!$this->work_address) $this->work_address = new ContactAddress();
        if (!$this->work_phone) $this->work_phone = new ContactPhone();
        $this->i18ns = $this->group->getExistingI18ns();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(CompanyPeer::DATABASE_NAME);
    
            try
            {
                $con->beginTransaction();
                
                $pr = $this->getRequestParameter('group_lang');
                
                $this->group->setName($this->getRequestParameter('group_name'));
                $this->group->setTypeId($this->getRequestParameter('group_type_id'));
                $this->group->setFoundedIn(mktime(0, 0, 0, 1, 1, $this->getRequestParameter('group_founded_in')));
                $this->group->setUrl($this->getRequestParameter('group_url'));
                $this->group->save();
                
                if (is_array($pr))
                {
                    foreach($pr as $key => $lang)
                    {
                        $ci18n = $this->group->getCurrentGroupI18n($lang);
                        $ci18n->setDisplayName(trim($this->getRequestParameter("group_displayname_$key")) != '' ? $this->getRequestParameter("group_displayname_$key") : $this->group->getName());
                        if ($this->group->getTypeId()!=GroupTypePeer::GRTYP_ONLINE)
                            $ci18n->setAbbreviation($this->getRequestParameter("group_abbreviation_$key"));
                        else
                            $ci18n->setAbbreviation('');
                        $ci18n->setIntroduction($this->getRequestParameter("group_introduction_$key"));
                        $ci18n->setMemberProfile($this->getRequestParameter("group_member_profile_$key"));
                        $ci18n->setEventsIntroduction($this->getRequestParameter("group_events_$key"));
                        $ci18n->save();
                    }
                }
                if (!$this->group->isNew() && count($diff = array_diff($this->i18ns, $pr))) $this->group->removeI18n($diff);
                
                $this->group->save();
                
                ActionLogPeer::Log($this->group, ActionPeer::ACT_UPDATE_GROUP_INFO);
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Group information has been saved successfully.', null, null, true);
                $this->redirect("@edit-group-profile?hash={$this->group->getHash()}");
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
        $pr = $this->getRequestParameter('group_lang');
        $pr = is_array($pr)?$pr:array();
        $i18n = sfContext::getInstance()->getI18N();
        foreach ($pr as $key => $lang)
        {
            if ($lang == '')
                $this->getRequest()->setError("group_lang_$key", $i18n->__('Please specify language'));
            if (mb_strlen($this->getRequestParameter("display_name_$key")) > 255)
                $this->getRequest()->setError("group_display_name_$key", $i18n->__('Group display name for %1 language must be maximum %2 characters long.', array('%1' => $i18n->getNativeName($lang), '%2' => 255)));
            if (mb_strlen($this->getRequestParameter("abbreviation_$key")) > 50)
                $this->getRequest()->setError("group_abbreviation_$key", $i18n->__('Group abbreviation for %1 language must be maximum %2 characters long.', array('%1' => $i18n->getNativeName($lang), '%2' => 50)));
            if (mb_strlen($this->getRequestParameter("group_introduction_$key")) > 2000)
                $this->getRequest()->setError("group_introduction_$key", $i18n->__('Group introduction for %1 language must be maximum %2 characters long.', array('%1' => $i18n->getNativeName($lang), '%2' => 2000)));
            if (mb_strlen($this->getRequestParameter("group_member_profile_$key")) > 2000)
                $this->getRequest()->setError("group_member_profile_$key", $i18n->__('Group member profile description for %1 language must be maximum %2 characters long.', array('%1' => $i18n->getNativeName($lang), '%2' => 2000)));
            if (mb_strlen($this->getRequestParameter("group_events_$key")) > 2000)
                $this->getRequest()->setError("group_events_$key", $i18n->__('Group events description for %1 language must be maximum %2 characters long.', array('%1' => $i18n->getNativeName($lang), '%2' => 2000)));
        }
        if ($this->group->getName() == $this->getRequestParameter('group_name')) $this->getRequest()->removeError('group_name');
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}