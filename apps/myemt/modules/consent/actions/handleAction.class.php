<?php

class handleAction extends EmtAction
{
    public function execute($request)
    {
        $settings = sfConfig::get('app_consent_live');
        $COOKIETTL = time() + (10 * 365 * 24 * 60 * 60);
        
        $this->user = $this->getUser()->getUser();
        
        $this->getContext()->getConfiguration()->loadHelpers('Url');
        
        if (!$this->user)
        {
            $this->redirect(url_for(str_replace('@myemt.', '@', $settings['index'])));
        }
        $storedConsent = $this->user->getConsentLogin(ConsentLoginPeer::CST_SERV_TYP_WINDOWS_LIVE);
        
        if (!$storedConsent)
        {
            $storedConsent = new ConsentLogin();
            $storedConsent->setUserId($this->user->getId());
            $storedConsent->setServiceId(ConsentLoginPeer::CST_SERV_TYP_WINDOWS_LIVE);
        }
        
        // Initialize the WindowsLiveLogin module.
        $wll = WindowsLiveLogin::initFromXml($settings['keyfile']);
        $wll->setDebug($settings['debug']);
        
        // Extract the 'action' parameter, if any, from the request.
        $action = @$_REQUEST['action'];
        
        if ($action == 'delauth') {
            $consent = $wll->processConsent($_REQUEST);
        
            // If a consent token is found, store it in the cookie that is 
            // configured in the settings.php file and then redirect to 
            // the main page.
            if ($consent) {
                if ($storedConsent->isNew())
                {
                    $storedConsent->save();
                }
                    
                $sql = "UPDATE EMT_CONSENT_LOGIN 
                        SET token=:token
                        WHERE id=".$storedConsent->getId();
                
                $token = $consent->getToken();
                $tokenobj = $wll->processConsentToken($token);

                $con = Propel::getConnection(PublicationPeer::DATABASE_NAME);
                
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':token', $token, PDO::PARAM_STR, strlen($token));
                $stmt->execute();
            }
        }
        return $this->renderText("<script>window.location = '".url_for(str_replace('@myemt.', '@', $settings['import']))."';</script>");
    }
    
    public function handleError()
    {
    }
    
}
