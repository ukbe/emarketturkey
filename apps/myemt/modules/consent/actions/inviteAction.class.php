<?php

class inviteAction extends EmtAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $members = $this->getRequestParameter('members');
            $relationcount = 0;
            foreach ($members as $member)
            {
                $tr = new EmailTransaction();
                $member = UserPeer::retrieveByPK($member);
                
                if (!($member instanceof User)) continue;
                
                $this->relation = $this->user->setupRelationWith($member->getId());
                
                if ($this->relation)
                {
                    $this->relationcount++;
                    
                    $data = new sfParameterHolder();
                    $data->set('cname', $member->getName());
                    $data->set('clname', $member->getLastname());
                    $data->set('uname', $this->user->getName());
                    $data->set('ulname', $this->user->getLastname());
                    $data->set('ugender', $this->user->getGender());
                    $data->set('message', $this->getRequestParameter('add-friend-message'));
                    
                    $vars = array();
                    $vars['email'] = $member->getLogin()->getEmail();
                    $vars['user_id'] = $member->getId();
                    $vars['data'] = $data;
                    $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_NETWORK_REQUEST;
                    
                    EmailTransactionPeer::CreateTransaction($vars);
                }
                $relation = null;
            }

            $c = new Criteria();
            $c->addJoin(ConsentContactPeer::CONSENT_LOGIN_ID, ConsentLoginPeer::ID, Criteria::INNER_JOIN);
            $c->addJoin(ConsentLoginPeer::USER_ID, UserPeer::ID, Criteria::INNER_JOIN);
            $c->add(UserPeer::ID, $this->user->getId());
            $c->add(ConsentContactPeer::ID, $this->getRequestParameter('candidates'), Criteria::IN);
            $candidates = ConsentContactPeer::doSelect($c);
            
            foreach ($candidates as $candidate)
            {
                $tr = new EmailTransaction();
                
                $invite = new InviteFriend();
                $invite->setInviterId($this->user->getId());
                $invite->setInviterTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                $invite->setInvitedToId($this->user->getId());
                $invite->setInvitedToTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                $invite->setEmail($candidate->getEmail());
                $invite->setMessage($this->getRequestParameter('invite-friend-message'));
                $invite->save();
                $invite->reload();
                
                $data = new sfParameterHolder();
                $data->add(array('iname' => '', 'ilname' => '', 'mnamelname' => $this->user->getName().' '.$this->user->getLastname(), 'invite_guid' => $invite->getGuid(), 'message' => str_replace(chr(13), '<br />', $invite->getMessage()), 'gender' => $this->user->getGender()));
                $vars = array();
                $vars['culture'] = (($this->user->getUserProfile()&&$this->user->getUserProfile()->getPreferredLanguage()!='')?$this->user->getUserProfile()->getPreferredLanguage():$this->getUser()->getCulture());
                $vars['email'] = $candidate->getEmail();
                $vars['user_id'] = null;
                $vars['data'] = $data;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_INVITE_FRIEND;

                EmailTransactionPeer::CreateTransaction($vars);
            }
            
            $this->candidates = $candidates;
        }
    }
    
    public function handleError()
    {
    }
    
}
