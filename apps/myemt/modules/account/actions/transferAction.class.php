<?php

class transferAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->act = myTools::pick_from_list($this->getRequestParameter('act'), array('finalize', 'takeover'), null);
        
        if (!$this->act) $this->redirect404();
        
        $mt = array('finalize' => TransferOwnershipRequestPeer::ROLE_CURRENT_OWNER,
                    'takeover' => TransferOwnershipRequestPeer::ROLE_NEW_OWNER
                );

        $st = array('finalize' => TransferOwnershipRequestPeer::STAT_ACCEPTED_BY_USER,
                    'takeover' => array(TransferOwnershipRequestPeer::STAT_PENDING, 
                                        TransferOwnershipRequestPeer::STAT_ACCEPTED_BY_USER
                                    )
                );

        if ($this->transfer = $this->sesuser->getTransferProcess($this->getRequestParameter('tid'), $st[$this->act], $mt[$this->act], true))
        {
            
            if ($this->getRequestParameter('opt') == 'out')
            {
                if ($this->act == 'takeover')
                {
                    $this->transfer->setStatus(TransferOwnershipRequestPeer::STAT_DECLINED_BY_USER);
                    $this->transfer->save();
                    $this->cancelled = true;

                    // Notify Process Initiator if different from current owner
                    if ($this->transfer->getCurrentOwnerId() != $this->transfer->getProcessInitById())
                    {
                        $this->notifyUser($this->transfer->getUserRelatedByProcessInitById(), $this->transfer);
                    }

                    // Notify Current Owner
                    $this->notifyUser($this->transfer->getUserRelatedByCurrentOwnerId(), $this->transfer);
                }
                elseif ($this->act == 'finalize')
                {
                    $this->transfer->setStatus(TransferOwnershipRequestPeer::STAT_CANCELLED_BY_OWNER);
                    $this->transfer->save();
                    $this->cancelled = true;

                    // Notify Process Initiator if different from current owner
                    if ($this->transfer->getCurrentOwnerId() != $this->transfer->getProcessInitById())
                    {
                        $this->notifyUser($this->transfer->getUserRelatedByProcessInitById(), $this->transfer);
                    }

                    // Notify Receiver User
                    $this->notifyUser($this->transfer->getUserRelatedByNewOwnerId(), $this->transfer);
                }
                $this->redirect('@homepage');
            }
        }
        else
        {
            if ($this->transfer = $this->sesuser->getTransferProcess($this->getRequestParameter('tid'), null, $mt[$this->act], true))
            {
                $this->show_message = true;
                return;
            }

            $this->redirect('@homepage');
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                if ($this->act == 'takeover')
                {
                    if ($this->getRequestParameter('opt') != 'in')
                        $this->redirect('@homepage');
                    
                    if ($this->transfer->getTransferCode() === $this->getRequestParameter('tr-code'))
                    {
                        $this->transfer->setStatus(TransferOwnershipRequestPeer::STAT_ACCEPTED_BY_USER);
                        $this->transfer->save();

                        // Notify Process Initiator if different from current owner
                        if ($this->transfer->getCurrentOwnerId() != $this->transfer->getProcessInitById())
                        {
                            $this->notifyUser($this->transfer->getUserRelatedByProcessInitById(), $this->transfer);
                        }
                        
                        $data = new sfParameterHolder();
                        $data->add(array('uname' => $this->transfer->getUserRelatedByCurrentOwnerId()->__toString(), 
                                         'recuser' => $this->sesuser->__toString(), 
                                         'recuserlink' => $this->sesuser->getProfileUrl(), 
                                         'transacc' => $this->transfer->getAccount()->__toString(),
                                         'transacclink' => $this->transfer->getAccount()->getProfileUrl(),
                                         'tid' => $this->transfer->getGuid()
                                        )
                                    );
                        $vars = array();
                        $vars['email'] = $this->transfer->getUserRelatedByCurrentOwnerId()->getLogin()->getEmail();
                        $vars['user_id'] = $this->transfer->getCurrentOwnerId();
                        $vars['data'] = $data;
                        $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_CONFIRM_ACCOUNT_TRANSFER;
    
                        EmailTransactionPeer::CreateTransaction($vars);
                        $this->redirect("@account-transfer?tid={$this->transfer->getGuid()}&act=takeover");
                    }
                    else
                    {
                        $this->getRequest()->setError('tr-code', $this->getContext()->getI18N()->__('Please enter the correct transfer code.'));
                        return;
                    }
                }
                elseif ($this->act == 'finalize')
                {
                    if ($this->getRequestParameter('opt') == 'in')
                    {
                        switch ($this->transfer->getAccountTypeId())
                        {
                            case PrivacyNodeTypePeer::PR_NTYP_COMPANY:
                                $company = $this->transfer->getAccount();
                                if ($company)
                                {
                                    $con = Propel::getConnection();
                                    try
                                    {
                                        $con->beginTransaction();

                                        $current = $company->getCompanyUserFor($this->transfer->getCurrentOwnerId(), PrivacyNodeTypePeer::PR_NTYP_USER);
                                        $new = $company->getCompanyUserFor($this->transfer->getNewOwnerId(), PrivacyNodeTypePeer::PR_NTYP_USER);
                                        if (!$new)
                                        {
                                            $new = new CompanyUser();
                                            $new->setCompanyId($company->getId());
                                            $new->setObjectId($this->transfer->getNewOwnerId());
                                            $new->setObjectTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                                        }

                                        $new->setRoleId(RolePeer::RL_CM_OWNER);
                                        $new->save();
                                        $current->setRoleId(RolePeer::RL_CM_FOLLOWER);
                                        $current->save();
                                        $this->transfer->setStatus(TransferOwnershipRequestPeer::STAT_COMPLETED);
                                        $this->transfer->save();
                                        $con->commit();
                                        
                                        // Notify Process Initiator if different from current owner
                                        if ($this->transfer->getCurrentOwnerId() != $this->transfer->getProcessInitById())
                                        {
                                            $this->notifyUser($this->transfer->getUserRelatedByProcessInitById(), $this->transfer);
                                        }
                                        // Notify New Owner
                                        $this->notifyUser($this->transfer->getUserRelatedByNewOwnerId(), $this->transfer);
                                        
                                        $this->redirect("@account-transfer?tid={$this->transfer->getGuid()}&act=finalize");
                                    }
                                    catch (Exception $e)
                                    {
                                        $con->rollBack();
                                        $this->error = true;
                                        return;
                                    }
                                }
                                break;
                            case PrivacyNodeTypePeer::PR_NTYP_GROUP:
                                $group  = $this->transfer->getAccount();
                                if ($group)
                                {
                                    $con = Propel::getConnection();
                                    try
                                    {
                                        $con->beginTransaction();

                                        $current = $group->hasMembership($this->transfer->getCurrentOwnerId(), PrivacyNodeTypePeer::PR_NTYP_USER);
                                        $new = $group->hasMembership($this->transfer->getNewOwnerId(), PrivacyNodeTypePeer::PR_NTYP_USER);
                                        if (!$new)
                                        {
                                            $new = new GroupMembership();
                                            $new->setGroupId($group->getId());
                                            $new->setObjectId($this->transfer->getNewOwnerId());
                                            $new->setObjectypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                                            $new->setStatus(GroupMembershipPeer::STYP_ACTIVE);
                                        }
                                         
                                        $new->setRoleId(RolePeer::RL_GP_OWNER);
                                        $new->save();
                                        $current->setRoleId(RolePeer::RL_GP_MEMBER);
                                        $current->save();
                                        $this->transfer->setStatus(TransferOwnershipRequestPeer::STAT_COMPLETED);
                                        $this->transfer->save();
                                        $con->commit();

                                        // Notify Process Initiator if different from current owner
                                        if ($this->transfer->getCurrentOwnerId() != $this->transfer->getProcessInitById())
                                        {
                                            $this->notifyUser($this->transfer->getUserRelatedByProcessInitById(), $this->transfer);
                                        }
                                        // Notify New Owner
                                        $this->notifyUser($this->transfer->getUserRelatedByNewOwnerId(), $this->transfer);

                                        $this->redirect("@account-transfer?tid={$this->transfer->getGuid()}&act=finalize");
                                    }
                                    catch (Exception $e)
                                    {
                                        $con->rollBack();
                                        $this->error = true;
                                        return;
                                    }
                                }
                                break;
                        }
                    }
                    $this->redirect('@homepage');
                }
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
    
    public function notifyUser($user, $transfer)
    {
        $data = new sfParameterHolder();
        $data->add(array('uname' => $user->__toString(), 
                         'status_id' => $transfer->getStatus(), 
                         'transacc' => $transfer->getAccount()->__toString(),
                         'transacclink' => $transfer->getAccount()->getProfileUrl(),
                        )
                    );
        $vars = array();
        $vars['email'] = $user->getLogin()->getEmail();
        $vars['user_id'] = $user->getId();
        $vars['data'] = $data;
        $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_ACCOUNT_TRANSFER_UPDATE;

        EmailTransactionPeer::CreateTransaction($vars);
    }
}