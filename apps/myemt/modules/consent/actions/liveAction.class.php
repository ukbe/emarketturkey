<?php

class liveAction extends EmtAction
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
        //Get the consent URL for the specified offers.
        $this->consenturl = $wll->getConsentUrl($settings['offers']);
        
        $token = null;
        $storedConsent = $this->user->getConsentLogin(ConsentLoginPeer::CST_SERV_TYP_WINDOWS_LIVE);

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
            $lid = $token->getLocationId();
            $domain = "https://livecontacts.services.live.com";
            
            $path = "/users/@L@$lid/rest/livecontacts";
            $url = "{$domain}{$path}";
            
            $httpReq = new HttpRequest($url);
            $httpReq->setContentType('application/xml; charset=utf-8');
            $httpReq->setHeaders(array('Authorization' => "DelegatedToken dt=\"{$token->getDelegationToken()}\"",
                                       'Pragma' => 'No-Cache'
                                       )
                               );
            $httpReq->send();
        
            $conts = new SimpleXmlElement($httpReq->getResponseBody());

            $con = Propel::getConnection();
            $sql = "SELECT EMAIL FROM EMT_CONSENT_CONTACT WHERE CONSENT_LOGIN_ID={$storedConsent->getId()}";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $consent_emails = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            $stmt = null;
            
            $banned_emails[] = $this->user->getLogin()->getEmail();
            foreach ($conts->Contacts->Contact as $cnt)
            {
                if (count($cnt->Emails->Email))
                {
                    foreach ($cnt->Emails->Email as $eml)
                    {
                        if (!in_array(strtolower($eml->Address), $banned_emails))
                        {
                            $already = array_search($eml->Address, $consent_emails);
                            if ($already === false)
                            {
                                $contact = new ConsentContact();
                                $contact->setConsentLoginId($storedConsent->getId());
                                $contact->setEmail($eml->Address);
                                $contact->setName($cnt->Profiles->Personal->FirstName);
                                $contact->setLastname($cnt->Profiles->Personal->LastName);
                                $contact->save();
                                $consent_emails[] = $eml->Address;
                            }
                        }
                    }
                }
            }
            $this->getContext()->getConfiguration()->loadHelpers('Url');
            return $this->renderText("<script>window.opener.location = '".url_for(str_replace('@myemt.', '@', $settings['add-friend']).'?lid='.$storedConsent->getId(), true)."'; window.close();</script>");
        }
        else
        {
            $this->redirect($this->consenturl);
        }
    }
    
    public function handleError()
    {
    }
    
}
