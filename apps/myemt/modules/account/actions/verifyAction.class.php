<?php

class verifyAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        if ((!$this->sesuser->isNew() && $this->sesuser->getLogin()->isVerified()) || ($this->sesuser->isNew() && $this->getRequestParameter('em') == '' && $this->getRequestParameter('ui') == ''))
        {
            $this->redirect('@homepage');
        }
        
        $this->resentMail = false;
        
        if ($this->getRequestParameter('resend') == 'yes' && !$this->sesuser->isNew())
        {
            $rcodes = explode('@', $this->sesuser->getLogin()->getRememberCode());
            $nid = uniqid();
            $this->sesuser->getLogin()->setRememberCode($nid . (count($rcodes) == 2 ? '@'.$rcodes[1] : ''));
            $this->sesuser->getLogin()->save();
            
            $data = new sfParameterHolder();
            $data->set('uname', $this->sesuser->getName());
            $data->set('ui', $nid);
            $data->set('em', $this->sesuser->getLogin()->getGuid());
            
            $vars = array();
            $vars['email'] = $this->sesuser->getLogin()->getEmail();
            $vars['user_id'] = $this->sesuser->getId();
            $vars['data'] = $data;
            $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_VERIFY_EMAIL_ADDR;
    
            EmailTransactionPeer::CreateTransaction($vars);
            
            $this->resentMail = true;
        }
        
        if ($this->getRequestParameter('ui') != '' && $this->getRequestParameter('em') != '')
        {
            $login = LoginPeer::retrieveByGuid($this->getRequestParameter('em'));

            if ($login)
            {
                $blk = $login->getBlockByReasonId(BlockReasonPeer::BR_TYP_VERIFICATION_REQUIRED);
                $rcodes = explode('@', $login->getRememberCode());
                
                if ($blk && $rcodes[0] == $this->getRequestParameter('ui'))
                {
                    $blk->delete();
                    $login->setRememberCode('');
                    $login->save();
                    
                    $this->getUser()->signIn($login);

                    $user = $login->getUser();
                    
                    // Process user invitations
                
                    if (isset($rcodes[1])) $this->invite = InviteFriendPeer::retrieveByPK($rcodes[1]);
                        
                    if (!$this->invite)
                    {
                        $this->invite = new InviteFriend();
                    }
                        
                    $c = new Criteria();
                    $c->add(InviteFriendPeer::EMAIL, $user->getLogin()->getEmail());
                    $c->setDistinct();
                    $invites = InviteFriendPeer::doSelect($c);
                    foreach ($invites as $inv)
                    {
                        switch ($inv->getInvitedToTypeId())
                        {
                            case PrivacyNodeTypePeer::PR_NTYP_USER :
                                $friend = $inv->getInvitedToObject();
                                if ($friend)
                                {
                                    $ph = new sfParameterHolder();
                                    $ph->set('user_id', $friend->getId());
                                    $ph->set('related_user_id', $user->getId());
                                    $ph->set('status', $this->invite->getGuid()==$inv->getGuid() ? RelationPeer::RL_STAT_ACTIVE : RelationPeer::RL_STAT_PENDING_CONFIRMATION);
                                    $ph->set('role_id', $this->invite->getGuid()==$inv->getGuid() ? RolePeer::RL_NETWORK_MEMBER : RolePeer::RL_CANDIDATE_NETWORK_MEMBER);
                                    RelationPeer::setupRelation($ph);
                                }
                                break;
                            case PrivacyNodeTypePeer::PR_NTYP_GROUP :
                                $group = $inv->getInvitedToObject();
                                if ($group)
                                {
                                    $mem = new GroupMembership();
                                    $mem->setObjectId($user->getId());
                                    $mem->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                                    $mem->setInviterId($inv->getInviterId());
                                    $mem->setInviterTypeId($inv->getInviterTypeId());
                                    $mem->setGroupId($group->getId());
                                    $mem->setStatus($this->invite->getGuid()==$inv->getGuid() ? GroupMembershipPeer::STYP_ACTIVE : GroupMembershipPeer::STYP_INVITED);
                                    $mem->setRoleId($this->invite->getGuid()==$inv->getGuid() ? RolePeer::RL_GP_MEMBER : RolePeer::RL_GP_CANDIDATE_MEMBER);
                                    $mem->save();
                                }
                                break;
                        }
                    }
    
                    if ($this->getRequestParameter('keepon')!='')
                    {
                        $this->redirect($this->getRequestParameter('keepon'));
                    }
                    
                    $this->redirect("@route");
                }
            }
            $this->redirect404();
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }
    
}