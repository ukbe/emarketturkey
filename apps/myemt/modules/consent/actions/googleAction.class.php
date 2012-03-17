<?php

class googleAction extends EmtAction
{
    public function execute($request)
    {
        include_once('Zend/Loader.php');
        Zend_Loader::loadClass('Zend_Gdata');
        Zend_Loader::loadClass('Zend_Gdata_Feed');
        Zend_Loader::loadClass('Zend_Oauth');
        Zend_Loader::loadClass('Zend_Oauth_Consumer');
        Zend_Loader::loadClass('Zend_Gdata_Query');
        Zend_Loader::loadClass('Zend_Oauth_Token_Access');
        Zend_Loader::loadClass('Zend_Oauth_Http_RequestToken');
        
        $this->user = $this->getUser()->getUser();

        $settings = sfConfig::get('app_consent_google');
        $oauth = $settings['OAuth'];
        $banned_emails = $settings['banned_emails'];
        if (!is_array($banned_emails)) $banned_emails = array();
        $this->getContext()->getConfiguration()->loadHelpers('Url');
        
        $a_token = null;
        $consentLogin = $this->user->getConsentLogin(ConsentLoginPeer::CST_SERV_TYP_GOOGLE);

        if ($consentLogin)
        {
            $a_token = unserialize($consentLogin->getTokenContent());
        }
        
        if ($a_token)
        {
            $config = array(
                'requestScheme'        => Zend_Oauth::REQUEST_SCHEME_HEADER,
                'version'              => '1.0',
                'consumerKey'          => $settings['Consumer_Key'],
                'consumerSecret'       => $settings['Consumer_Secret'],
                'signatureMethod'      => 'HMAC-SHA1',
                'requestTokenUrl'      => 'https://www.google.com/accounts/OAuthGetRequestToken',
                'userAuthorizationUrl' => 'https://www.google.com/accounts/OAuthAuthorizeToken',
                'accessTokenUrl'       => 'https://www.google.com/accounts/OAuthGetAccessToken'
            );
            
            $con = Propel::getConnection();
            $sql = "SELECT EMAIL FROM EMT_CONSENT_CONTACT WHERE CONSENT_LOGIN_ID={$consentLogin->getId()}";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $consent_emails = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            $stmt = null;
            
            $banned_emails[] = $this->user->getLogin()->getEmail();
            
            try {
                $consumer = new Zend_Oauth_Consumer($config);
    
                $query = new Zend_Gdata_Query('https://www.google.com/m8/feeds/contacts/default/full');
                $query->setMaxResults(1000000);
                $http  = $a_token->getHttpClient($config);
                $http->setRequestScheme(Zend_Oauth::REQUEST_SCHEME_QUERYSTRING);
                $gdata = new Zend_Gdata($http, 'MY EMT');
                $gdata->setMajorProtocolVersion(3);
                
                $feed = $gdata->getFeed($query);
                $results = array();
                foreach($feed as $entry){
                    $xml = simplexml_load_string($entry->getXML());
                
                    foreach ($xml->email as $e) {
                        $eml = (string) $e['address'];
                        if (!in_array(strtolower($eml), $banned_emails) && array_search($eml, $consent_emails)===false)
                        {
                            $contact = new ConsentContact();
                            $contact->setConsentLoginId($consentLogin->getId());
                            $contact->setEmail($eml);
                            $contact->setName($xml->givenName);
                            $contact->setLastname($xml->familyName);
                            $contact->save();
                            $consent_emails[] = $eml;
                        }
                    }
                }
            } 
            catch (Exception $e) {
                die('ERROR:' . $e->getMessage());  
            }
            return $this->renderText("<script>window.opener.location = '".url_for(str_replace('@myemt.', '@', $settings['add-friend']).'?lid='.$consentLogin->getId(), true)."'; window.close();</script>");
        }
        else
        {
            $config = array(
                'requestScheme'        => Zend_Oauth::REQUEST_SCHEME_HEADER,
                'version'              => '1.0',
                'consumerKey'          => $settings['Consumer_Key'],
                'consumerSecret'       => $settings['Consumer_Secret'],
                'signatureMethod'      => 'HMAC-SHA1',
                'requestTokenUrl'      => 'https://www.google.com/accounts/OAuthGetRequestToken',
                'userAuthorizationUrl' => 'https://www.google.com/accounts/OAuthAuthorizeToken',
                'accessTokenUrl'       => 'https://www.google.com/accounts/OAuthGetAccessToken'
            );
            $consumer = new Zend_Oauth_Consumer($config);

            $oauthOptions = array(
                'oauth_consumer_key'   => $settings['Consumer_Key'],
                'oauth_nonce'          => '1234567890ABCDEF1234567890ABCDEF1234567890ABCDEF1234567890ABCDEF1234567890ABCDEF',
                'oauth_signature_method' => 'HMAC-SHA1',
                'oauth_signature'      => $oauth['oauth_signature'],
                'oauth_timestamp'      => time(),
                'scope'                => $settings['scope'],
                'oauth_callback'       => url_for(str_replace('@myemt.', '@', $settings['handler']), true),
                'oauth_version'        => $oauth['oauth_version']
            );
            $r_token = $consumer->getRequestToken($oauthOptions);
            $this->getUser()->setAttribute('token-request', serialize($r_token));
            $this->getUser()->setAttribute('token-access', null);

            $consumer->redirect();
        }
    }
    
    public function handleError()
    {
    }
    
}
