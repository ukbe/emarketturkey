<?php

class startAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->contact_cities = array();
        $this->is_online = ($this->getRequestParameter('group_type_id') == GroupTypePeer::GRTYP_ONLINE);
                
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $register_fields = $this->getRequest()->getParameterHolder();
            $register_fields->set('group_logins', array(RolePeer::RL_GP_OWNER => $this->sesuser));
            $data = new sfParameterHolder();
            
            $this->group = GroupPeer::Create($register_fields, &$data);

            if ($this->group instanceof Group)
            {
                ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_CREATE_GROUP, null, $this->group);

                $vars = array();
                $vars['email'] = $data->get('email');
                $vars['user_id'] = $data->get('user_id');
                $vars['data'] = $data;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_CREATE_GROUP;

                EmailTransactionPeer::CreateTransaction($vars);
            }
            else
            {
                $this->errorWhileSaving = true;
                return sfView::SUCCESS;
            }

            $keepon = $this->getRequestParameter('keepon');
            $this->redirect($keepon != '' ? $keepon : "@group-route?hash={$this->group->getHash()}");
        }
        elseif ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $this->contact_cities = GeonameCityPeer::getCitiesFor($this->getRequestParameter('group_country'));
        }
        else
        {
            return sfView::SUCCESS;
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function validate()
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $pr = $this->getRequestParameter('group_lang');
            $pr = is_array($pr)?$pr:array();
            foreach ($pr as $key => $lang)
            {
                if ($lang == '') $this->getRequest()->setError("group_lang_$key", sfContext::getInstance()->getI18N()->__('Please specify language'));
                if ($key > 0 && mb_strlen($this->getRequestParameter("group_name_$key"), 'utf-8') < 3 || mb_strlen($this->getRequestParameter("group_name_$key"), 'utf-8') > 255) $this->getRequest()->setError("group_name_$key", sfContext::getInstance()->getI18N()->__('Group name should be %1 to %2 characters long.', array('%1' => 3, '%2' => 255)));
                if (mb_strlen($this->getRequestParameter("group_abbreviation_$key")) > 50)
                    $this->getRequest()->setError("group_abbreviation_$key", sfContext::getInstance()->getI18N()->__('Group abbreviation for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 50)));
                if (mb_strlen($this->getRequestParameter("group_introduction_$key")) > 2000)
                    $this->getRequest()->setError("group_introduction_$key", sfContext::getInstance()->getI18N()->__('Group introduction for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 2000)));
                if (mb_strlen($this->getRequestParameter("group_member_profile_$key")) > 2000)
                    $this->getRequest()->setError("group_member_profile_$key", sfContext::getInstance()->getI18N()->__('Group member profile description for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 2000)));
                if (mb_strlen($this->getRequestParameter("group_events_$key")) > 2000)
                    $this->getRequest()->setError("group_events_$key", sfContext::getInstance()->getI18N()->__('Group events description for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 2000)));
            }

            if (mb_strlen($this->getRequestParameter('group_city'), 'utf-8') > 50) $this->getRequest()->setError('group_city', 'City/Town name should include maximum 50 characters.');
            if (mb_strlen($this->getRequestParameter('group_postalcode'), 'utf-8') > 10) $this->getRequest()->setError('group_postalcode', 'Postal Code should include maximum 10 characters.');
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}