<?php

class inviteAction extends EmtManageEventAction
{
    protected $enforceEvent = true;
    
    public function handleAction($isValidationError)
    {
        $this->time_scheme = $this->event->getTimeScheme();

        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Invite to Event: %1', array('%1' => $this->event->getName())));

        $this->network = array();
        $this->network[RolePeer::RL_NETWORK_MEMBER] = $this->sesuser->getFriends();
        
        switch ($this->otyp)
        {
            case PrivacyNodeTypePeer::PR_NTYP_COMPANY:
                $this->network[RolePeer::RL_CM_PARTNER] = $this->owner->getPartners(null, null, CompanyUserPeer::CU_STAT_ACTIVE);
                $this->network[RolePeer::RL_CM_FOLLOWER] = $this->owner->getFollowers();
                break;
            case PrivacyNodeTypePeer::PR_NTYP_GROUP:
                $this->network[RolePeer::RL_GP_MEMBER] = $this->owner->getMembers();
                $this->network[RolePeer::RL_GP_FOLLOWER] = $this->owner->getFollowers();
                $this->network[RolePeer::RL_GP_LINKED_GROUP] = $this->owner->getLinkedGroups();
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection();
            
            try
            {
                $con->beginTransaction();

                $selected = $this->getRequestParameter('network');

                foreach ($selected as $type_id => $invites)
                {
                    foreach ($invites as $id => $set)
                    {
                        if (!($invite = $this->event->getInviteFor($id, $type_id)) && ($this->sesuser->can(ActionPeer::ACT_INVITE_TO_EVENT, $id, $type_id) || $this->owner->can(ActionPeer::ACT_INVITE_TO_EVENT, $id, $type_id)))
                        {
                            $obj = PrivacyNodeTypePeer::retrieveObject($id, $type_id);
                            $obowner = PrivacyNodeTypePeer::getTopOwnerOf($obj);
                            
                            $in = new EventInvite();
                            $in->setEventId($this->event->getId());
                            $in->setInviterId($this->owner->getId());
                            $in->setInviterTypeId($this->otyp);
                            $in->setSubjectId($id);
                            $in->setSubjectTypeId($type_id);
                            $in->setRsvpStatus(EventPeer::EVN_ATTYP_PENDING);
                            $in->save();
                            
                            $data = new sfParameterHolder();
                            $data->add(array('iname' => $obj->__toString(), 
                                             'mnamelname' => $this->owner->getName($obowner->getUserProfile() && $obowner->getUserProfile()->getPreferredLanguage() ? $obowner->getUserProfile()->getPreferredLanguage() : ''), 
                                             'ename' => $this->event->getName($obowner->getUserProfile() && $obowner->getUserProfile()->getPreferredLanguage() ? $obowner->getUserProfile()->getPreferredLanguage() : ''),
                                             'invite' => $this->event->getId()
                                            )
                                        );
                            $vars = array();
                            $vars['email'] = $obowner->getLogin()->getEmail();
                            $vars['user_id'] = $obowner->getId();
                            $vars['data'] = $data;
                            $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_INVITE_USER_TO_EVENT;

                            EmailTransactionPeer::CreateTransaction($vars);
                        }
                    }
                }
                $con->commit();
                $this->redirect("{$this->route}&action=details&id={$this->event->getId()}");
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                die;
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while sending invitations. Please try again later.', null, null, false);
                ErrorLogPeer::Log($this->event->getId(), PrivacyNodeTypePeer::PR_NTYP_EVENT, "Error occured while sending invitations.", $e);
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function validate()
    {
        $pr = $this->getRequestParameter('event_lang');
        $pr = is_array($pr)?$pr:array();
        
        foreach ($pr as $key => $lang)
        {
            if (mb_strlen($this->getRequestParameter("event_name_$key")) > 255)
                $this->getRequest()->setError("event_name_$key", sfContext::getInstance()->getI18N()->__('Event name for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 255)));
            if (mb_strlen($this->getRequestParameter("event_introduction_$key")) > 1800)
                $this->getRequest()->setError("event_introduction_$key", sfContext::getInstance()->getI18N()->__('Event description for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 1800)));
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}