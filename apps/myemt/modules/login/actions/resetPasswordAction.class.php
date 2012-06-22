<?php

class resetPasswordAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->error_msg = null;

        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(LoginPeer::DATABASE_NAME);
            
            if ($this->hasRequestParameter('log') && $this->hasRequestParameter('req'))
            {
                $this->login = LoginPeer::retrieveByGuid($this->getRequestParameter('log'));
                if (!$this->login) $this->redirect404();
                
                $resetreq = $this->login->getPasswordResetRequest($this->getRequestParameter('req'));
                if (!$resetreq) $this->redirect404();
                
                try 
                {
                    $con->beginTransaction();
                    
                    $this->login->setPassword($this->getRequestParameter('new_passwd'));
                    $this->login->save();
                    
                    $resetreq->delete();
                    
                    $con->commit();
                    $this->setTemplate('resetPasswordComplete');
                }
                catch (Exception $e)
                {
                    $con->rollBack();
                    $this->error_msg = 'An error occured while saving your new password.<br />Please try againg later.';
                    $this->setTemplate('resetPasswordApply');
                }
            }
            else
            {
                $c = new Criteria();
                $c->add(LoginPeer::EMAIL, $this->getRequestParameter('reset_email'));
                $this->login = LoginPeer::doSelectOne($c);
                $this->user = $this->login->getUser();
                if (!$this->user)
                {
                    ErrorLogPeer::Log($user_id, PrivacyNodeTypePeer::PR_NTYP_USER, 'Missing User record for Login #').$login->getId();
                    $this->getRequest()->setError('reset_email', 'This email address is not registered.');
                    return sfView::SUCCESS;
                }
                
                try
                {
                    $con->beginTransaction();
                    
                    $resetreq = new PasswordResetRequest();
                    $resetreq->setLoginId($this->login->getId());
                    $resetreq->save();
                    $resetreq->reload();
    
                    $data = new sfParameterHolder();
                    $data->set('uname', $this->user->getName());
                    $data->set('loginuid', $this->login->getGuid());
                    $data->set('reqid', $resetreq->getGuid());
                    
                    $vars = array();
                    $vars['email'] = $this->login->getEmail();
                    $vars['user_id'] = $this->user->getId();
                    $vars['data'] = $data;
                    $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_RESET_PASSWORD;
    
                    $tr = EmailTransactionPeer::CreateTransaction($vars, false);
                    
                    $con->commit();
                    
                    $tr->reload();
                    $tr->deliver();
                    
                    $this->setTemplate('resetPasswordMailSent');
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    $this->error_msg = 'An error occured while sending password reset information.<br />Please try againg later.';
                }
            }
        }
        else
        {
            if ($this->hasRequestParameter('log') && $this->hasRequestParameter('req'))
            {
                $this->login = LoginPeer::retrieveByGuid($this->getRequestParameter('log'));
                if (!$this->login) $this->redirect404();
                $this->user = $this->login->getUser();
                if (!$this->user) $this->redirect404();
                
                $resetreq = $this->login->getPasswordResetRequest($this->getRequestParameter('req'));
                if (!$resetreq) $this->redirect404();
                $this->setTemplate('resetPasswordApply');
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function validate()
    {
        $request = $this->getRequest();
        if ($this->hasRequestParameter('log') && $this->hasRequestParameter('req'))
        {
            $request->removeError('reset_email');
            $request->removeError('captcha');
        }
        else
        {
            $request->removeError('new_passwd');
            $request->removeError('new_passwd_rpt');
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    }
