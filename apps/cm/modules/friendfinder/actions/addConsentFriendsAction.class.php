<?php

class addConsentFriendsAction extends EmtAction
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
            $members = $this->getRequestParameter('members', array());
            $this->relationcount = 0;
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
            $this->redirect(url_for(str_replace('@cm.', '@', $settings['invite-friend'])).'?lid='.$this->consentLogin->getId());
        }
        else
        {
            $banned_emails = $settings['banned_emails'];
            if (!is_array($banned_emails)) $banned_emails = array();
            
            if ($this->consentLogin)
            {
                $this->members = array();
                $c = new Criteria();
                $c->addJoin(UserPeer::LOGIN_ID, LoginPeer::ID, Criteria::INNER_JOIN);
                $c->addJoin(LoginPeer::EMAIL, ConsentContactPeer::EMAIL, Criteria::INNER_JOIN);
                $c->addJoin(ConsentContactPeer::CONSENT_LOGIN_ID, ConsentLoginPeer::ID, Criteria::INNER_JOIN);
                $c->add(ConsentLoginPeer::ID, $this->consentLogin->getId());
                $members = UserPeer::doSelect($c);
                foreach ($members as $member)
                {
                    if (!$this->user->isFriendsWith($member->getId())) $this->members[] = $member;
                } 
                if (!count($this->members)) $this->redirect(url_for(str_replace('@cm.', '@', $settings['invite-friend'])).'?lid='.$this->consentLogin->getId());
                
                $this->banned_emails = $banned_emails;
            }
            else
            {
                $this->redirect(url_for(str_replace('@cm.', '@', $settings['index'])));
            }
        }
    }
    
    public function handleError()
    {
    }
    
}
