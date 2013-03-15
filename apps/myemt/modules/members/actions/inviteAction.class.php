<?php

class inviteAction extends EmtManageGroupAction
{
    protected $actionID = ActionPeer::ACT_INVITE_TO_GROUP;
      
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    public function handleAction($isValidationError)
    {
        if (!$this->goodToRun) $this->redirect404();
        
        $this->tips = array();

        $con = Propel::getConnection();
        $sql = "SELECT * FROM
                ( 
                    SELECT EMT_USER.* FROM EMT_RELATION
                    INNER JOIN EMT_USER ON RELATED_USER_ID=EMT_USER.ID
                    WHERE EMT_RELATION.USER_ID=".($this->sesuser->getId()?$this->sesuser->getId():0)." AND STATUS=".RelationPeer::RL_STAT_ACTIVE."
                    UNION
                    SELECT EMT_USER.* FROM EMT_RELATION
                    INNER JOIN EMT_USER ON USER_ID=EMT_USER.ID
                    WHERE EMT_RELATION.RELATED_USER_ID=".($this->sesuser->getId()?$this->sesuser->getId():0)." AND STATUS=".RelationPeer::RL_STAT_ACTIVE."
                ) EUSR
                WHERE EUSR.ID NOT IN 
                (
                    SELECT OBJECT_ID FROM EMT_GROUP_MEMBERSHIP 
                    WHERE GROUP_ID={$this->group->getId()} AND OBJECT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER." AND EMT_GROUP_MEMBERSHIP.STATUS=".GroupMembershipPeer::STYP_ACTIVE."
                )"; 
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $this->friends = UserPeer::populateObjects($stmt);
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(MediaItemPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $invites = $this->getRequestParameter('friends');
                $invited = array();
                foreach ($invites as $invite)
                {
                    if (!$this->group->hasMembership($invite, PrivacyNodeTypePeer::PR_NTYP_USER) && ($invitee = UserPeer::retrieveByPK($invite)) && $this->sesuser->isFriendsWith($invite))
                    {
                        $in = new GroupMembership();
                        $in->setInviterTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                        $in->setInviterId($this->sesuser->getId());
                        $in->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                        $in->setObjectId($invite);
                        $in->setStatus(GroupMembershipPeer::STYP_INVITED);
                        $in->setGroupId($this->group->getId());
                        $in->setRoleId(RolePeer::RL_GP_MEMBER);
                        $in->save();
                        array_push($invited, $invite);

                        $data = new sfParameterHolder();
                        $data->add(array('iname' => $invitee->getName(), 
                                         'mnamelname' => $this->sesuser->getName().' '.$this->sesuser->getLastname(), 
                                         'gname' => $this->group->getDisplayName($this->cult)
                                        )
                                    );
                        $vars = array();
                        $vars['email'] = $invitee->getLogin()->getEmail();
                        $vars['user_id'] = $invite;
                        $vars['data'] = $data;
                        $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_INVITE_USER_TO_GROUP;
        
                        EmailTransactionPeer::CreateTransaction($vars);
                    }
                }
                $this->invited = UserPeer::retrieveByPKs($invited);
                
                $con->commit();
                $this->getUser()->setMessage('Friends Invited!', 'Selected friends have been successfully invited to your group.', null, null, true);
                $this->setTemplate('friendsInvited');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while inviting your friends. Please try again later.', null, null, false);
                ErrorLogPeer::Log($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, "Error occured while inviting user's friends.", $e);
            }
        }
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