<?php

class EmtLoginValidator extends sfValidator
{    
    public function initialize($context, $parameters = null)
    {
        // initialize parent
        parent::initialize($context);
        
        // set defaults
        $this->setParameter('login_error', 'Invalid input');
        
        $this->getParameterHolder()->add($parameters);

        return true;
    }

    public function execute(&$value, &$error)
    {
        $password_param = $this->getParameter('password');
        $password = $this->getContext()->getRequest()->getParameter($password_param);

        $email = $value;

        $c = new Criteria();
        $c->add(LoginPeer::EMAIL, "UPPER(".LoginPeer::EMAIL.") = UPPER('$email')", Criteria::CUSTOM);
        $login = LoginPeer::doSelectOne($c);

        // nickname exists?
        if ($login)
        {
            // password is OK?
            if (sha1($login->getSalt().$password) == $login->getSha1Password())
            {
                /*
                $c = new Criteria();
                $c->add(BlocklistPeer::LOGIN_ID, $login->getId());
                $blitem = BlocklistPeer::doSelectOne($c); 
                if ($blitem)
                {
                    $error = $blitem->getBlockReason()->getName();
                    return false;
                }
*/
                return true;
            }
        }
        $error = $this->getParameter('login_error');
        return false;
    }
}