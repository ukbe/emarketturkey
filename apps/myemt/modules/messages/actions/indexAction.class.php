<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class indexAction extends EmtMessageAction
{

    public function execute($request)
    {
        $list = array();

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
                ORDER BY CREATED_AT DESC
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
                ORDER BY CREATED_AT DESC
            ";
        }

        $con = Propel::getConnection();

        $stmt = $con->prepare($sql);
        $stmt->execute();
        $this->messages = ($this->folder == 'inbox' ? MessageRecipientPeer::populateObjects($stmt) : MessagePeer::populateObjects($stmt));

        if ($this->hasRequestParameter('callback'))
        {
            $items = array();

            sfLoader::loadHelpers(array('Url', 'Date'));

            foreach ($this->messages as $mess)
            {
                $message = ($mess instanceof Message ? $mess : $mess->getMessage());
                $items[] = array('IMG' => $message->getSender()->getProfilePictureUri(), 'NAME' => $message->getSender()->__toString(), 'MSG' => $message->getBody(), 'LINK' => url_for($message->getUrl(), true), 'DATE' => format_datetime($message->getCreatedAt('U'), 'r'), 'NEW' => !$mess->getIsRead());
            }
            if ($this->folder == 'inbox')
            {
                $sql = "SELECT COUNT(*) FROM ($sql) WHERE IS_READ=0";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                $num = $stmt->fetchColumn(0);
            }
            else
            {
                $num = 0;
            }
            $items = array('NEW' => $num, 'ITEMS' => $items);

            return $this->renderText($this->getRequestParameter('callback') . "(" . json_encode($items) . ");");
        }
        
        $this->folders = $this->account ? $this->account->getMessageFolders() : array();

    }

}