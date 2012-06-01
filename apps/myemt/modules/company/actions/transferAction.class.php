<?php

class transferAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->member = null;
        
        if ($this->transfer = $this->company->getTransferProcess(array(TransferOwnershipRequestPeer::STAT_PENDING, TransferOwnershipRequestPeer::STAT_ACCEPTED_BY_USER)))
        {
            if ($this->getRequestParameter('act') == 'cancel' && $this->getRequestParameter('tid') == $this->transfer->getGuid())
            {
                $this->transfer->setStatus($this->sesuser->getId() == $this->transfer->getProcessInitById() ? TransferOwnershipRequestPeer::STAT_CANCELLED_BY_INITER : TransferOwnershipRequestPeer::STAT_CANCELLED_BY_OWNER);
                $this->transfer->save();
                return;
            }
            if ($this->getRequestParameter('act') == 'notify' && $this->transfer->getStatus() == TransferOwnershipRequestPeer::STAT_PENDING)
            {
                // create email transaction to notify user
                $data = new sfParameterHolder();
                $data->add(array('uname' => $this->transfer->getUserRelatedByNewOwnerId()->__toString(), 
                                 'inituser' => $this->transfer->getUserRelatedByProcessInitById()->__toString(), 
                                 'inituserlink' => $this->transfer->getUserRelatedByProcessInitById()->getProfileUrl(), 
                                 'transacc' => $this->company->__toString(),
                                 'transacclink' => $this->company->getProfileUrl(),
                                 'tid' => $this->transfer->getGuid()
                                )
                            );
                $vars = array();
                $vars['email'] = $this->transfer->getUserRelatedByNewOwnerId()->getLogin()->getEmail();
                $vars['user_id'] = $this->transfer->getUserRelatedByNewOwnerId()->getId();
                $vars['data'] = $data;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_NOTIFY_ACCOUNT_TRANSFER;

                EmailTransactionPeer::CreateTransaction($vars);
                $this->redirect("@company-account?action=transfer&hash={$this->company->getHash()}");
            }
            return;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$this->transfer)
        {
            if (!$isValidationError)
            {

                $c = new Criteria();
                $c->addJoin(UserPeer::LOGIN_ID, LoginPeer::ID, Criteria::LEFT_JOIN);
                $c->add(LoginPeer::ID, "NOT EXISTS (SELECT 1 FROM EMT_BLOCKLIST WHERE EMT_BLOCKLIST.LOGIN_ID=EMT_USER.LOGIN_ID AND EMT_BLOCKLIST.ACTIVE=1)", Criteria::CUSTOM);
                $c->add(LoginPeer::EMAIL, $this->getRequestParameter('search_email'));
                $this->member = UserPeer::doSelectOne($c);
                if (!$this->member)
                {
                    $this->getRequest()->setError('search_email', 'E-mail address is invalid.');
                    return;
                }
                if ($this->getRequestParameter('act') == 'init')
                {
                    $transfer = new TransferOwnershipRequest();
                    $transfer->setAccountId($this->company->getId());
                    $transfer->setAccountTypeId(PrivacyNodeTypePeer::PR_NTYP_COMPANY);
                    $transfer->setCurrentOwnerId($this->company->getOwner()->getId());
                    $transfer->setNewOwnerId($this->member->getId());
                    $transfer->setProcessInitById($this->sesuser->getId());
                    $transfer->setEmailAddress($this->member->getLogin()->getEmail());
                    $transfer->setTransferCode(strtoupper(uniqid()));
                    $transfer->setStatus(TransferOwnershipRequestPeer::STAT_PENDING);
                    $transfer->save();
                    $transfer->reload();

                    $data = new sfParameterHolder();
                    $data->add(array('uname' => $this->member->__toString(), 
                                     'inituser' => $this->sesuser->__toString(), 
                                     'inituserlink' => $this->sesuser->getProfileUrl(), 
                                     'transacc' => $this->company->__toString(),
                                     'transacclink' => $this->company->getProfileUrl(),
                                     'tid' => $transfer->getGuid()
                                    )
                                );
                    $vars = array();
                    $vars['email'] = $this->member->getLogin()->getEmail();
                    $vars['user_id'] = $this->member->getId();
                    $vars['data'] = $data;
                    $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_NOTIFY_ACCOUNT_TRANSFER;

                    EmailTransactionPeer::CreateTransaction($vars);
                    
                    $this->redirect("@company-account?action=transfer&hash={$this->company->getHash()}");
                }
            }
        }
    }

    public function validate()
    {
        if ($this->getRequestParameter('search_email') == $this->sesuser->getLogin()->getEmail())
            $this->getRequest()->setError('search_email', 'E-mail address is invalid.');
        
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}