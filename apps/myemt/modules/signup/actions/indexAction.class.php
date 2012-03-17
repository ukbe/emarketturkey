<?php

class indexAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        if (!$this->sesuser->isNew())
        {
            $this->redirect('@homepage');
        }
        
        if ($this->getRequestParameter('invite')!='')
        {
            $this->invite = InviteFriendPeer::retrieveByGuid($this->getRequestParameter('invite'));
        }
        else
        {
            $this->invite = null;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                $birthdate = mktime(0, 0, 0, $this->getRequestParameter('bd_month'), $this->getRequestParameter('bd_day'), $this->getRequestParameter('bd_year'));
                $earliest_valid_date = mktime(0, 0, 0, date('m'), date('d'), date('Y')-13);
                
                if ($birthdate > $earliest_valid_date){
                    $this->errorWhileSaving = true;
                    return sfView::SUCCESS;
                }
                                
                $signup_fields = $this->getRequest()->getParameterHolder();
                $signup_fields->set('registration_ip', $this->getRequest()->getHttpHeader('addr', 'remote'));
                $data = new sfParameterHolder();
                try
                {
                    $user = UserPeer::SignupUser($signup_fields, &$data, ($this->invite instanceof InviteFriend));
                    if ($user instanceof User)
                    {
                        $vars = array();
                        $vars['email'] = $data->get('email');
                        $vars['user_id'] = $data->get('user_id');
                        $vars['data'] = $data;
                        $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_SIGNUP;
    
                        EmailTransactionPeer::CreateTransaction($vars);
                    }
                    else
                    {
                        $this->errorWhileSaving = true;
                        return sfView::SUCCESS;
                    }
                    
                }
                catch(Swift_Exception $e)
                {
                    //EmailTransactionPeer::Schedule();
                }

                $user = UserPeer::retrieveByPK($data->get('user_id'));
                
                if ($this->invite){
                    $user->getLogin()->setRememberCode($user->getLogin()->getRememberCode() . '@' . $this->invite->getId());
                    $user->getLogin()->save();
                }
                
                $this->getUser()->signIn($user->getLogin());

                if ($this->getRequestParameter('keepon')!='')
                {
                    $this->redirect($this->getRequestParameter('keepon'));
                }
                
                $this->redirect("@route");
            }
            else
            {
                return sfView::SUCCESS;
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }
    
}