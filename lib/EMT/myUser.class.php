<?php

class myUser extends sfBasicSecurityUser
{
    private $user_obj;
    private $login_obj;
    private $user_profile;
    
    public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
    {
        // initialize parent
        parent::initialize($dispatcher, $storage, $options);
        
        if ($this->isAuthenticated())
        {
            if (!$this->getUser() || $this->login_obj->countBlocksExceptReasonIds(array(BlockReasonPeer::BR_TYP_VERIFICATION_REQUIRED)))
            {
                $this->signOut();
            }
        }
        else if ($this->getUser())
        {
            $this->signOut();
        }
    }
        
    public function signIn($login, $remember = false)
    {
        if ($login->countBlocksExceptReasonIds(array(BlockReasonPeer::BR_TYP_VERIFICATION_REQUIRED)))
        {
            return false;
        }
        $this->login_obj = $login;
        $this->user_obj = $login->getUser();
        $this->setAttribute('login_id', $login->getId(), 'subscriber');
        $this->setAttribute('customer_type', $login->getRole()->getSysname(), 'subscriber');
        $this->setAuthenticated(true);
        $this->addCredentials($login->getRoleNames());
        
        foreach ($this->user_obj->getOwnerships() as $property)
        {
            if ($property->getObjectTypeId() == PrivacyNodeTypePeer::PR_NTYP_COMPANY)
                $this->addCredential('company');
            else
                $this->addCredential('group');
        }
        
        $this->setLoginEmail('login_email', $login->getEmail());
        ActionLogPeer::Log($this->getUser(), ActionPeer::ACT_LOG_IN);

        if ($this->login_obj->getBlockByReasonId(BlockReasonPeer::BR_TYP_VERIFICATION_REQUIRED))
            $this->setAttribute('verified', 'no');
       
        if ($remember)
        {
            $token = md5(uniqid(rand(), true));
            $login->setRememberCode($token);
            $login->save();
            
            $cookieparams = session_get_cookie_params();
            $cook = base64_encode(serialize(array($login->getRememberCode(), $login->getEmail())));
            sfContext::getInstance()->getResponse()->setCookie('EMARKETTURKEY', $cook, time()+60*60*24*15, '/', $cookieparams['domain']);
        }
        return true;
    }
    
    
    public function signOut()
    {
        $this->getAttributeHolder()->removeNamespace('subscriber');
        $this->user_obj = null;
        $this->login_obj = null;
        $this->user_profile = null;
        $this->ownerships = null;
        
        $cookieparams = session_get_cookie_params();
        sfContext::getInstance()->getResponse()->setCookie('EMARKETTURKEY', '', time() - 3600, '/', $cookieparams['domain']);
        
        $this->setAuthenticated(false);
        $this->clearCredentials();
    }

    public function getLoginId()
    {
        return $this->getAttribute('login_id', 0, 'subscriber');
    }

    public function getCustomerType()
    {
        return $this->getAttribute('customer_type', RolePeer::RL_ALL, 'subscriber');
    }

    public function getLogin()
    {
        if (!isset($this->login_obj))
        {
            $this->login_obj = LoginPeer::retrieveByPk($this->getLoginId()); 
        }
        return $this->login_obj; 
    }

    public function getUser()
    {
        if (!isset($this->user_obj))
        {
            $login = $this->getLogin();
            if ($login)
            {
                $this->user_obj = $login->getUser();
            }
            else
            {
                return new User();
            }
        }
        return $this->user_obj;
    }
    
    public function getLoginEmail()
    {
        return $this->getAttribute('login_email', '', 'subscriber');
    }
    
    public function setLoginEmail($v)
    {
        return $this->setAttribute('login_email', $v, 'subscriber');
    }
    
    public function hasProfile()
    {
        return $this->getProfile()!==null;
    }
    
    public function getProfile()
    {
        if ($this->user_profile)
        {
            return user_profile;
        }
        else
        {
            $this->user_profile = $this->getUser()->getUserProfile();
            return $this->user_profile;
        }
    }
    
    public function setSearchFlash($keyword)
    {
        $flash = $this->getAttribute("recentsearches", array(), 'myemt');
        array_push($flash, $keyword);
        $flash = array_unique($flash);
        $this->setAttribute("recentsearches", $flash, 'myemt');
    }
    
    public function setMessage($header, $message, array $attr_header=null, array $attr_message=null, $persist=true)
    {
        $this->setFlash('message_header', sfContext::getInstance()->getI18N()->__($header, $attr_header), $persist);
        $this->setFlash('message', sfContext::getInstance()->getI18N()->__($message, $attr_message), $persist);
    }
    
    public function getUserCompany($company_id)
    {
        if ($this->user_obj)
        {
            return $this->user_obj->getCompany($company_id);
        }
        else
        {
            return null;
        }
    }
    
    public function addSearchTerm($keyword, $ns)
    {
        $ar = $this->getAttribute('searchterms', array(), $ns);
        $ar[$keyword] = $keyword;
        $this->setAttribute('searchterms', $ar, $ns);
    }
    
    public function getSearchTerms($ns)
    {
        return $this->getAttribute('searchterms', array(), $ns);
    }

    public function isLoggedIn()
    {
        return (($this->getUser() instanceof  User) && !$this->getUser()->isNew());
    }
    
}
