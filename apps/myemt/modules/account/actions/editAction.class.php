<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class editAction extends EmtManageAction
{

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
        
        $this->login = $this->sesuser->getLogin();
    }
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->origin = $this->getRequestParameter('_ref', $this->_referer);
        $this->origin = !$this->origin ? '@account' : $this->origin;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                $this->sesuser->setName($this->getRequestParameter('user_name'));
                $this->sesuser->setLastname($this->getRequestParameter('user_lastname'));
                $this->sesuser->setAlternativeEmail($this->getRequestParameter('user_alternative_email'));
                if ($this->sesuser->isModified())
                {
                    $this->sesuser->save();
                    ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_UPDATE_PERSONAL_INFO);
                }
                if (!$this->login->hasUsername() && $this->getRequestParameter('user_username') != '')
                {
                    $this->login->setUsername($this->getRequestParameter('user_username'));
                    $username = $this->getRequestParameter('user_username');
                }
                if ($this->login->getEmail() != $this->getRequestParameter('user_account_email'))
                {
                    $emaillog = unserialize($this->login->getEmailLog());
                    $emaillog[] = array(time(), $this->login->getEmail());
                    while (strlen(serialize($emaillog)) > 400)
                    {
                        array_shift($emaillog);
                    }
                    $this->login->setEmailLog(serialize($emaillog));
                    $this->login->setEmail($this->getRequestParameter('user_account_email'));
                    $accountemail = $this->getRequestParameter('user_account_email');
                }

                if ($this->login->isModified())
                {
                    $this->login->save();
                    if (isset($username)) ActionLogPeer::Log($this->sesuser, ActionPeer::ACT_SET_USERNAME);
                    if (isset($accountemail))
                    {
                        if (!$this->login->getBlockByReasonId(BlockReasonPeer::BR_TYP_VERIFICATION_REQUIRED))
                        {
                            $block = new Blocklist();
                            $block->setLoginId($this->login->getId());
                            $block->setBlockreasonId(BlockReasonPeer::BR_TYP_VERIFICATION_REQUIRED);
                            $block->setActive(true);
                            $block->save();
                        }
                        $this->sesuser->sendVerificationEmail();
                    }
                }
                $this->redirect($this->origin);
            }
        }
    }

    public function validate()
    {
        if ($this->getRequestParameter('user_account_email') == $this->login->getEmail())
            $this->getRequest()->removeError('user_account_email');
        if ($this->getRequestParameter('user_username') == $this->login->getUsername())
            $this->getRequest()->removeError('user_username');
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}