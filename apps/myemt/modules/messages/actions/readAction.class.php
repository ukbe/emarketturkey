<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class readAction extends EmtMessageAction
{

    public function execute($request)
    {
        $this->message = myTools::unplug($this->getRequestParameter('_m'));
        
        if (!$this->message)
        {
            $params = array();
            if ($this->account) $params[] = "acc={$this->account->getPlug()}";
            if ($this->folder) $params[] = "folder={$this->folder}";
            $params = implode('&', $params);
            $this->redirect("@messages" . ($params ? "?$params" : ''));
        }

        if ($this->account)
        {
            $list[] = array($this->account->getId(), $this->account->getObjectTypeId());
        }
        else
        {
            foreach ($this->props as $prop)
            {
                $list[] = array($prop->getId(), $prop->getObjectTypeId());
            }
        }
        
        if ($this->folder == 'sent')
        {
            foreach ($list as $key => $item)
            {
                $list[$key] = "SENDER_ID=".$item[0]." AND SENDER_TYPE_ID=".$item[1];
            }
            $sql = "
                SELECT * FROM EMT_MESSAGE
                WHERE (".implode(' OR ', $list).")
                AND DELETED_AT IS NULL
                AND EMT_MESSAGE.ID={$this->message->getId()}
            ";
        }
        elseif ($this->folder == 'inbox')
        {
            foreach ($list as $key => $item)
            {
                $list[$key] = "RECIPIENT_ID=".$item[0]." AND RECIPIENT_TYPE_ID=".$item[1];
            }
            $sql = "
                SELECT EMT_MESSAGE_RECIPIENT.* FROM EMT_MESSAGE
                LEFT JOIN EMT_MESSAGE_RECIPIENT ON EMT_MESSAGE.ID=EMT_MESSAGE_RECIPIENT.MESSAGE_ID
                WHERE (".implode(' OR ', $list).")
                AND EMT_MESSAGE_RECIPIENT.DELETED_AT IS NULL
                AND EMT_MESSAGE.ID={$this->message->getId()}
            ";
        }

        $con = Propel::getConnection();

        $stmt = $con->prepare($sql);
        $stmt->execute();
        $this->messages = ($this->folder == 'inbox' ? MessageRecipientPeer::populateObjects($stmt) : MessagePeer::populateObjects($stmt));
        
        if (!count($this->messages))
        {
            $params = array();
            if ($this->account) $params[] = "acc={$this->account->getPlug()}";
            if ($this->folder) $params[] = "folder={$this->folder}";
            $params = implode('&', $params);
            $this->redirect("@messages" . ($params ? "?$params" : ''));
        }
        else
        {
            $this->message = $this->messages[0];
        }

        if ($act = myTools::pick_from_list($this->getRequestParameter('_a'), array('delete', 'unread', 'read')))
        {
            switch ($act)
            {
                case 'delete' :
                    $this->message->setDeletedAt(time());
                    $this->message->save();
                    break;
                case 'unread' :
                    if ($this->message instanceof MessageRecipient)
                    {
                        $this->message->setIsRead(false);
                        $this->message->save();
                    }
                    break;
            }

            $params = array();
            if ($this->account) $params[] = "acc={$this->account->getPlug()}";
            if ($this->folder) $params[] = "folder={$this->folder}";
            $params = implode('&', $params);
            $this->redirect("@messages" . ($params ? "?$params" : ''));
        }

        if (!($this->message instanceof Message))
        {
            $this->recipient = $this->message;
            $this->message = $this->message->getMessage();
            $this->recipient->setIsRead(true);
            $this->recipient->save();
        }

        $this->recipients = $this->message->getRecipients();

        $this->folders = $this->account ? $this->account->getMessageFolders() : array();

    }
    
}