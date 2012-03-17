<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class sendMailAction extends EmtGroupAction
{
    protected $actionID = ActionPeer::ACT_INVITE_TO_GROUP;
    
    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        if (!$this->goodToRun) $this->redirect404();
        
        $this->emaillist = $this->getRequestParameter('emaillist');
        $this->message = $this->getRequestParameter('message');
        $this->cult = $this->getRequestParameter('cult');
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(MediaItemPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $validated_emails = preg_grep('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i', preg_split('/[\n\r]+/', $this->emaillist));
                foreach ($validated_emails as $vmail)
                {
                    $invite = new InviteFriend();
                    $invite->setInviterId($this->sesuser->getId());
                    $invite->setInviterTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                    $invite->setInvitedToId($this->group->getId());
                    $invite->setInvitedToTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
                    $invite->setEmail($vmail);
                    $invite->setMessage($this->message);
                    $invite->save();
                    $invite->reload();
                    
                    $data = new sfParameterHolder();
                    $data->add(array('iname' => '', 
                                     'ilname' => '', 
                                     'mnamelname' => $this->sesuser->getName().' '.$this->sesuser->getLastname(), 
                                     'invite_guid' => $invite->getGuid(), 
                                     'message' => str_replace(chr(13), '<br />', $this->message), 
                                     'gender' => $this->sesuser->getGender(),
                                     'gname' => $this->group->getDisplayName($this->cult)
                                    )
                                );
                    $vars = array();
                    $vars['culture'] = $this->cult;
                    $vars['email'] = $vmail;
                    $vars['user_id'] = null;
                    $vars['data'] = $data;
                    $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_INVITE_TO_GROUP;
    
                    EmailTransactionPeer::CreateTransaction($vars);
                }
                $con->commit();
                $this->sent = $validated_emails;
                $this->setTemplate('mailsSent');
                $this->getUser()->setMessage('Friends Invited!', 'Specified friends have been successfully invited to your group.', null, null, true);
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while inviting your friends. Please try again later.', null, null, false);
                ErrorLogPeer::Log($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, $e->getMessage());
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
}