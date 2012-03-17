<?php

class MessagePeer extends BaseMessagePeer
{
    CONST MFOLDER_INBOX = 1;
    CONST MFOLDER_SENT = 2;
    CONST MFOLDER_ARCHIVED = 3;
    
    CONST DIR_TWO_WAY       = 1;
    CONST DIR_SENT          = 2;
    CONST DIR_RECEIVED      = 3;
    
    
    public static function createMessage($sender, $recipients, $title, $body, $thread_id = null, $related_object_id = null, $related_object_type_id = null)
    {
        $message = new Message();
        $message->setSenderId($sender->getId());
        $message->setSenderTypeId(PrivacyNodeTypePeer::getTypeFromClassname($sender));
        $message->setSubject($title);
        $message->setBody($body);
        $message->setThreadId($thread_id);
        $message->setRelatedObjectId($related_object_id);
        $message->setRelatedObjectTypeId($related_object_type_id);
        $message->save();
        
        $sendertop = PrivacyNodeTypePeer::getTopOwnerOf($sender);
        
        foreach ($recipients as $type_id => $typreps)
        {
            foreach ($typreps as $repid)
            {
                $rcpnt = PrivacyNodeTypePeer::retrieveObject($repid, $type_id);
                
                $delivery = new MessageRecipient();
                $delivery->setRecipientId($repid);
                $delivery->setRecipientTypeId($type_id);
                $delivery->setMessageId($message->getId());
                $delivery->save();

                $data = new sfParameterHolder();
                $data->set('sendername', $sender->__toString());
                $data->set('rcpntname', $rcpnt->__toString());
                $data->set('subject', $title);
                $data->set('message', $body);
                $data->set('message_id', $message->getId());

                $topowner = PrivacyNodeTypePeer::getTopOwnerOf($rcpnt);

                $vars = array();
                $vars['email'] = $topowner->getLogin()->getEmail();
                $vars['user_id'] = $topowner->getId();
                $vars['data'] = $data;
                $vars['namespace'] = EmailTransactionNamespacePeer::EML_TR_NS_NEW_MESSAGE;

                ActionLogPeer::Log($sendertop, ActionPeer::ACT_SEND_MESSAGE, $rcpnt);
                EmailTransactionPeer::CreateTransaction($vars);
            }
            
        }
                                      
    }
    
    public static function getMessages($sender = null, $recipient = null, $thread_id = null, $object = null, $direction = self::DIR_ONE_WAY, $sender_deleted = null, $rec_deleted = null, $page = null)
    {
        $sender_id = is_object($sender) ? $sender->getId() : null;
        $sender_type_id = is_object($sender) ? $sender->getObjectTypeId() : null;
        $recipient_id = is_object($recipient) ? $recipient->getId() : null;
        $recipient_type_id = is_object($recipient) ? $recipient->getObjectTypeId() : null;
        $object_id = is_object($object) ? $object->getId() : null;
        $object_type_id = is_object($object) ? $object->getObjectTypeId() : null;
        
        $sender_del_check = (!is_null($sender_deleted) ? "AND EMT_MESSAGE.DELETED_AT" . ($sender_deleted ? " IS NOT NULL" : " IS NULL") : '');
        $rec_del_check = (!is_null($rec_deleted) ? "AND EMT_MESSAGE_RECIPIENT.DELETED_AT" . ($rec_deleted ? " IS NOT NULL" : " IS NULL") : '');
        
        $sender_chk = $sender_id ? "(EMT_MESSAGE.SENDER_ID=$sender_id AND EMT_MESSAGE.SENDER_TYPE_ID=$sender_type_id)$sender_del_check" : "";
        $rec_chk = $recipient_id ? "(EMT_MESSAGE_RECIPIENT.RECIPIENT_ID=$recipient_id AND EMT_MESSAGE_RECIPIENT.RECIPIENT_TYPE_ID=$recipient_type_id)$rec_del_check" : "";

        $wheres['OR'] = $wheres = array();

        $wheres['OR'][] = implode(' AND ', array_filter(array($sender_chk, $rec_chk)));

        if ($direction == self::DIR_TWO_WAY)
        {
            $sender_del_check = (!is_null($sender_deleted) ? "AND EMT_MESSAGE_RECIPIENT.DELETED_AT" . ($sender_deleted ? " IS NOT NULL" : " IS NULL") : '');
            $rec_del_check = (!is_null($rec_deleted) ? "AND EMT_MESSAGE.DELETED_AT" . ($rec_deleted ? " IS NOT NULL" : " IS NULL") : '');
            $sender_chk = $sender_id ? "(EMT_MESSAGE_RECIPIENT.RECIPIENT_ID=$sender_id AND EMT_MESSAGE_RECIPIENT.RECIPIENT_TYPE_ID=$sender_type_id)$sender_del_check" : "";
            $rec_chk = $recipient_id ? "(EMT_MESSAGE.SENDER_ID=$recipient_id AND EMT_MESSAGE.SENDER_TYPE_ID=$recipient_type_id)$rec_del_check" : "";
            $wheres['OR'][] = implode(' AND ', array_filter(array($sender_chk, $rec_chk)));
        }
             
        if ($thread_id) $wheres[] = "EMT_MESSAGE.THREAD_ID=$thread_id";  
        if ($object_id) $wheres[] = "EMT_MESSAGE.RELATED_OBJECT_ID=$object_id AND EMT_MESSAGE.RELATED_OBJECT_TYPE_ID=$object_type_id";  
        $wheres['OR'] = '((' . implode(') OR (', $wheres['OR']) . '))';
        $wheres = implode(' AND ', $wheres);
        $sql = "
            SELECT DISTINCT * FROM EMT_MESSAGE
            LEFT JOIN EMT_MESSAGE_RECIPIENT ON EMT_MESSAGE.ID=EMT_MESSAGE_RECIPIENT.MESSAGE_ID 
            WHERE $wheres
            ORDER BY EMT_MESSAGE.CREATED_AT DESC
        ";

        $pager = new EmtPager('Message', 20);
        $pager->setSql($sql);
        $pager->setPage($page);
        $pager->init();
        return $pager;
    }
    
}
