<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class loginAction extends EmtAction
{
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->getUser()->isAuthenticated())
        {
            $this->redirect('@homepage');
        }
        
        //$this->getRequest()->getParameterHolder()->set('referer', $this->getRequest()->getReferer());
        
        if ($this->getRequest()->getMethod() != sfRequest::POST)
        {
            $this->setSigninReferer();
        }
        else
        {
            if (!$isValidationError){
                // handle the form submission
                $c = new Criteria();
                $c->add(LoginPeer::EMAIL, "UPPER(".LoginPeer::EMAIL.") = UPPER('". $this->getRequestParameter('email')."')", Criteria::CUSTOM);
                $login = LoginPeer::doSelectOne($c);

                if (!$this->getUser()->signIn($login, $this->getRequestParameter('remember')))
                {
                    $this->blockeduser = $login->getUser();
                    $this->setTemplate('blockedAccount');
                    return sfView::SUCCESS;
                }
                
                // redirect to mymemt homepage or recent page
                if ($this->getRequestParameter('stack') !== 'A10' && $this->_ref=='')
                {
                    //$this->redirect('@homepage');
                }

                $this->redirect($this->_ref ? $this->_ref : '@homepage');
                
            }
            else{
                return sfView::SUCCESS;
            }
        }
    }

    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }

    private function setSigninReferer()
    {
      $this->_ref = $this->getContext()->getActionStack()->getSize() > 1 ? 
                        $this->_here : ($this->_ref ? $this->_ref : '@homepage');
      /*
      if (!$this->_ref && $this->getContext()->getActionStack()->getSize() > 0) {
          $action = $this->getContext()->getActionStack()->getFirstEntry()->getActionInstance();
          $security = $action->getSecurityConfiguration(); 
          $action_name = $this->getContext()->getActionStack()->getFirstEntry()->getActionName();
    
          // module/config/security.yml action setting takes priority
          if (isset($security[$action_name]['is_secure']) && $security[$action_name]['is_secure']) {
              $referer = urldecode($this->_here);
          } elseif (isset($security['all']['is_secure']) && $security['all']['is_secure']) {
              $referer = urldecode($this->_here);         
          } else {
              $referer = $default_referer;
          }
    
      } else {
          $referer = $default_referer;
      }
      */
      
      //$this->getUser()->setAttribute('referer', $_redir);
    }
}