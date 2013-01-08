<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class inviteFriendsAction extends EmtAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        // Redirect to camp application
        $this->redirect("@camp.invite-friends", 301);

        $this->user = $this->getUser()->getUser();
        
        $this->emaillist = $this->getRequestParameter('emaillist');
        $this->message = $this->getRequestParameter('message');
        $this->cult = $this->getRequestParameter('cult');
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $validated_emails = preg_grep('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i', preg_split('/[\n\r]+/', $this->emaillist));
            $con = Propel::getConnection();
            $sql = "SELECT EMAIL FROM EMT_LOGIN";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $regemaillist = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            $validated_emails = array_diff($validated_emails, $regemaillist);

            foreach ($validated_emails as $vmail)
            {
                $invite = new InviteFriend();
                $invite->setInviterId($this->user->getId());
                $invite->setInviterTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                $invite->setInvitedToId($this->user->getId());
                $invite->setInvitedToTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                $invite->setEmail($vmail);
                $invite->setMessage($this->message);
                $invite->save();
                $invite->reload();
                
                $data = new sfParameterHolder();
                $data->add(array('iname' => '', 'ilname' => '', 'mnamelname' => $this->user->getName().' '.$this->user->getLastname(), 'invite_guid' => $invite->getGuid(), 'message' => str_replace(chr(13), '<br />', $this->message), 'gender' => $this->user->getGender()));
                $vars = array();
                $vars['culture'] = $this->cult;
                $vars['email'] = $vmail;
                $vars['user_id'] = null;
                $vars['data'] = $data;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_INVITE_FRIEND;

                EmailTransactionPeer::CreateTransaction($vars);
            }
            $this->sent = count($validated_emails);
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