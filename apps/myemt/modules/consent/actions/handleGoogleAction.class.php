<?php

class handleGoogleAction extends EmtAction
{
    public function execute($request)
    {
        include_once('Zend/Loader.php');
        Zend_Loader::loadClass('Zend_Oauth');
        Zend_Loader::loadClass('Zend_Oauth_Consumer');
        Zend_Loader::loadClass('Zend_Oauth_Token_Access');
        Zend_Loader::loadClass('Zend_Oauth_Http_RequestToken');
        
        $settings = sfConfig::get('app_consent_google');
        
        $this->user = $this->getUser()->getUser();
        
        $this->getContext()->getConfiguration()->loadHelpers('Url');
        
        if (!$this->user || $this->getUser()->getAttribute('token-request') == null)
        {
            $this->redirect(url_for(str_replace('@myemt.', '@', $settings['index']), true));
        }
        
        $consentLogin = $this->user->getConsentLogin(ConsentLoginPeer::CST_SERV_TYP_GOOGLE);
        
        if (!$consentLogin)
        {
            $consentLogin = new ConsentLogin();
            $consentLogin->setUserId($this->user->getId());
            $consentLogin->setServiceId(ConsentLoginPeer::CST_SERV_TYP_GOOGLE);
        }
        
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
        try {
            $consumer = new Zend_Oauth_Consumer($config);

            $r_token = unserialize($this->getUser()->getAttribute('token-request'));
            
            $a_token = $consumer->getAccessToken($_GET, $r_token);
        
        
            if ($a_token) {
                if ($consentLogin->isNew())
                {
                    $consentLogin->save();
                }
                    
                $sql = "UPDATE EMT_CONSENT_LOGIN 
                        SET token=:token
                        WHERE id=".$consentLogin->getId();
                
                $con = Propel::getConnection(PublicationPeer::DATABASE_NAME);
                
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':token', serialize($a_token), PDO::PARAM_STR, strlen(serialize($a_token)));
                $stmt->execute();
                
                $this->redirect(url_for(str_replace('@myemt.', '@', $settings['import'])), true);
            }
        }
        catch (Exception $e)
        {
            ErrorLogPeer::Log($this->user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, "Error while importing Google Contacts: ".$e->getMessage());
        }
        $this->redirect(url_for(str_replace('@myemt.', '@', $settings['import']), true));
    }
    
    public function handleError()
    {
    }
    
}
