<?php

class emtBasicSecurityFilter extends sfBasicSecurityFilter 
{
  public function execute ($filterChain)
  {
    // execute this filter only once
    if ($this->isFirstCall())
    {
      if ($cookie = $this->getContext()->getRequest()->getCookie('EMARKETTURKEY'))
      {
        $value = unserialize(base64_decode($cookie));
        $c = new Criteria();
        $c->add(LoginPeer::REMEMBER_CODE, $value[0]);
        $c->add(LoginPeer::EMAIL, $value[1]);
        $login = LoginPeer::doSelectOne($c);
        if ($login)
        {
          // sign in
          $this->getContext()->getUser()->signIn($login);
        }
      }
    }
    
    parent::execute($filterChain);
    
    // execute next filter
    //$filterChain->execute();
  }
}