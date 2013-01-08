<?php

class inviteConsentFriendsAction extends EmtAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();

        $this->consentLogin = ConsentLoginPeer::retrieveByPk($this->getRequestParameter('lid'));
        if (!$this->user || !$this->consentLogin || $this->user->getId()!=$this->consentLogin->getUserId()) $this->redirect('@friendfinder');
        $this->consent_type = $this->consentLogin->getServiceId();
        $this->getContext()->getConfiguration()->loadHelpers('Url');
        
        switch ($this->consent_type)
        {
            case ConsentLoginPeer::CST_SERV_TYP_WINDOWS_LIVE : $settings = sfConfig::get('app_consent_live'); break;
            case ConsentLoginPeer::CST_SERV_TYP_GOOGLE : $settings = sfConfig::get('app_consent_google'); break;
            case ConsentLoginPeer::CST_SERV_TYP_YAHOO : $settings = sfConfig::get('app_consent_yahoo'); break;
        }

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            $c = new Criteria();
            $c->addJoin(ConsentContactPeer::CONSENT_LOGIN_ID, ConsentLoginPeer::ID, Criteria::INNER_JOIN);
            $c->add(ConsentLoginPeer::ID, $this->consentLogin->getId());
            $c->add(ConsentContactPeer::ID, $this->getRequestParameter('candidates', array()), Criteria::IN);
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
                $data->add(array('iname' => $candidate->getName(), 'ilname' => $candidate->getLastname(), 'mnamelname' => $this->user->getName().' '.$this->user->getLastname(), 'invite_guid' => $invite->getGuid(), 'message' => str_replace(chr(13), '<br />', $invite->getMessage()), 'gender' => $this->user->getGender()));
                $vars = array();
                $vars['culture'] = (($this->user->getUserProfile()&&$this->user->getUserProfile()->getPreferredLanguage()!='')?$this->user->getUserProfile()->getPreferredLanguage():$this->getUser()->getCulture());
                $vars['email'] = $candidate->getEmail();
                $vars['user_id'] = null;
                $vars['data'] = $data;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_INVITE_FRIEND;

                EmailTransactionPeer::CreateTransaction($vars);
            }
            $this->redirect('@myemt.homepage');
        }
        else
        {   

            $banned_emails = $settings['banned_emails'];
            if (!is_array($banned_emails)) $banned_emails = array();
            
            if ($this->consentLogin)
            {
                $c = new Criteria();
                $c->addJoin(ConsentContactPeer::EMAIL, LoginPeer::EMAIL, Criteria::LEFT_JOIN);
                $c->addJoin(LoginPeer::ID, UserPeer::LOGIN_ID, Criteria::LEFT_JOIN);
                $c->add(ConsentContactPeer::CONSENT_LOGIN_ID, $this->consentLogin->getId());
                $c->add(UserPeer::ID, NULL, Criteria::ISNULL);
                $this->candidates = ConsentContactPeer::doSelect($c);
                
                $this->banned_emails = $banned_emails;
            }
            else
            {
                $this->redirect(url_for($settings['index']));
            }
        }
    }
    
    public function handleError()
    {
    }
    
}
