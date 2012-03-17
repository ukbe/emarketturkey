<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class readAction extends EmtAction
{
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        $this->companies = $this->user->getCompanies(RolePeer::RL_CM_OWNER);
                
        if (is_numeric($this->getRequestParameter('id')))
        {
            $userid = $this->user->getId();
            foreach ($this->companies as $comp)
            {
                $companyidarr[] = $comp->getId();
            }
            $companyids = implode(',', $companyidarr);
            
            $messageid = $this->getRequestParameter('id');

            $con = Propel::getConnection();
            
            $sql = "SELECT EMT_MESSAGE.* FROM EMT_MESSAGE
                    LEFT JOIN EMT_MESSAGE_RECIPIENT ON EMT_MESSAGE_RECIPIENT.MESSAGE_ID=EMT_MESSAGE.ID
                    WHERE
                    EMT_MESSAGE.ID=$messageid AND 
                    ((EMT_MESSAGE_RECIPIENT.DELETED_AT IS NULL AND 
                    ((EMT_MESSAGE_RECIPIENT.RECIPIENT_ID=$userid AND EMT_MESSAGE_RECIPIENT.RECIPIENT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER.")
                    ".(count($this->companies)?"OR (EMT_MESSAGE_RECIPIENT.RECIPIENT_ID IN ($companyids) AND EMT_MESSAGE_RECIPIENT.RECIPIENT_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY.")":"")."))
                    OR
                    (EMT_MESSAGE.DELETED_AT IS NULL AND
                    ((EMT_MESSAGE.SENDER_ID=$userid AND EMT_MESSAGE.SENDER_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_USER.")
                    ".(count($this->companies)?"OR (EMT_MESSAGE.SENDER_ID IN ($companyids) AND EMT_MESSAGE.SENDER_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_COMPANY.")":"").")))
                    and rownum<2";
                    
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $message = MessagePeer::populateObjects($stmt);
            if (count($message))
                $this->message = $message[0];  
            else
                $this->redirect('@messages');

            if ($this->getRequestParameter('mod') == 'del')
            {
                if (($this->message->getSenderId() == $this->user->getId()) && ($this->message->getSenderTypeId()==PrivacyNodeTypePeer::PR_NTYP_USER))
                {
                    $this->message->setDeletedAt(date());
                    $this->message->save();
                }
                else if ($rec = $this->message->getRecipientFor($this->user->getId(), PrivacyNodeTypePeer::PR_NTYP_USER))
                {
                    $rec->setDeletedAt(date());
                    $rec->save();
                }
                else
                {
                    foreach ($this->companies as $comp)
                    {
                        
                    }
                }
                
                $this->getUser()->setMessage('Message Deleted!', 'Your message was deleted successfully.');
                $this->redirect('@messages');
            }
            
            $rec = $this->message->getRecipientFor($userid, PrivacyNodeTypePeer::PR_NTYP_USER);
            if (!$rec) 
            {
                foreach ($this->companies as $company)
                {
                    $rec = $this->message->getRecipientFor($company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY);
                }
            }
            
            if ($rec)
            {
                if (!$rec->getIsRead())
                {
                    $rec->setIsRead(1);
                    $rec->save();
                }
            }

            $sql = "SELECT ".MessagePeer::TABLE_NAME.".* FROM ".MessagePeer::TABLE_NAME."
                    WHERE ((".MessagePeer::SENDER_ID."=$userid AND
                          ".MessagePeer::SENDER_TYPE_ID."=".PrivacyNodeTypePeer::PR_NTYP_USER.")
                          ".(count($this->companies)?" OR (".MessagePeer::SENDER_ID." IN ($companyids) AND
                               ".MessagePeer::SENDER_TYPE_ID."=".PrivacyNodeTypePeer::PR_NTYP_COMPANY.")":"").") AND
                          ".MessagePeer::DELETED_AT." IS NULL AND
                          ".MessagePeer::THREAD_ID."=".$this->message->getThreadId()." AND 
                          ".MessagePeer::ID."!=".$this->message->getId()."
                    UNION
                    SELECT ".MessagePeer::TABLE_NAME.".* FROM ".MessageRecipientPeer::TABLE_NAME.",".MessagePeer::TABLE_NAME." 
                    WHERE ((".MessageRecipientPeer::RECIPIENT_ID."=$userid AND
                          ".MessageRecipientPeer::RECIPIENT_TYPE_ID."=".PrivacyNodeTypePeer::PR_NTYP_USER.")
                          ".(count($this->companies)?" OR (".MessageRecipientPeer::RECIPIENT_ID." IN ($companyids) AND
                               ".MessageRecipientPeer::RECIPIENT_TYPE_ID."=".PrivacyNodeTypePeer::PR_NTYP_COMPANY.")":"").") AND
                          ".MessageRecipientPeer::DELETED_AT." IS NULL AND
                          ".MessageRecipientPeer::MESSAGE_ID."=".MessagePeer::ID." AND 
                          ".MessagePeer::THREAD_ID."=".$this->message->getThreadId()." AND 
                          ".MessagePeer::ID."!=".$this->message->getId();
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $this->thread_messages = MessagePeer::populateObjects($stmt);
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