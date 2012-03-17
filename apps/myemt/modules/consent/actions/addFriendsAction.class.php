<?php

class addFriendsAction extends EmtAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();

        $settings = sfConfig::get('app_consent_live');
        $banned_emails = $settings['banned_emails'];
        if (!is_array($banned_emails)) $banned_emails = array();
        
        // Initialize the WindowsLiveLogin module.
        $wll = WindowsLiveLogin::initFromXml($settings['keyfile']);
        $wll->setDebug($settings['debug']);
        
        $token = null;
        $storedConsent = $this->user->getConsentLogin();

        if ($storedConsent)
        {
            $token = $wll->processConsentToken($storedConsent->getTokenContent());
        }
        
        if ($token && !$token->isValid())
        {
            $token = null;
        }
        
        if ($token)
        {
            $this->members = array();
            $c = new Criteria();
            $c->addJoin(UserPeer::LOGIN_ID, LoginPeer::ID, Criteria::INNER_JOIN);
            $c->addJoin(LoginPeer::EMAIL, ConsentContactPeer::EMAIL, Criteria::INNER_JOIN);
            $c->addJoin(ConsentContactPeer::CONSENT_LOGIN_ID, ConsentLoginPeer::ID, Criteria::INNER_JOIN);
            $c->add(ConsentLoginPeer::ID, $storedConsent->getId());
            $members = UserPeer::doSelect($c);
            foreach ($members as $member)
            {
                if (!$this->user->isFriendsWith($member->getId())) $this->members[] = $member;
            } 
            
            $c = new Criteria();
            $c->addJoin(ConsentContactPeer::EMAIL, LoginPeer::EMAIL, Criteria::LEFT_JOIN);
            $c->addJoin(LoginPeer::ID, UserPeer::LOGIN_ID, Criteria::LEFT_JOIN);
            $c->add(ConsentContactPeer::CONSENT_LOGIN_ID, $storedConsent->getId());
            $c->add(UserPeer::ID, NULL, Criteria::ISNULL);
            $this->candidates = ConsentContactPeer::doSelect($c);
            
            $this->banned_emails = $banned_emails;
        }
        else
        {
            $this->getContext()->getConfiguration()->loadHelpers('Url');
            $this->redirect(url_for(str_replace('@myemt.', '@', $settings['index'])));
        }
    }
    
    public function handleError()
    {
    }
    
}
