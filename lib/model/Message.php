<?php

class Message extends BaseMessage
{
    protected $sender = null;
    protected $aRecipients = null;
    protected $_conversationRecipient = null;
    private $hash = null;
    
    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_MESSAGE;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, PrivacyNodeTypePeer::PR_NTYP_MESSAGE) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getSender()
    {
        if (!is_null($this->sender))
        {
            return $this->sender;
        }
        else
        {
            if ($this->sender_type_id == PrivacyNodeTypePeer::PR_NTYP_USER)
            {
                $this->sender = UserPeer::retrieveByPK($this->sender_id);
                return $this->sender;
            }
            elseif ($this->sender_type_id==PrivacyNodeTypePeer::PR_NTYP_COMPANY)
            {
                $this->sender = CompanyPeer::retrieveByPK($this->sender_id);
                return $this->sender;
            }
            elseif ($this->sender_type_id==PrivacyNodeTypePeer::PR_NTYP_GROUP)
            {
                $this->sender = GroupPeer::retrieveByPK($this->sender_id);
                return $this->sender;
            }
        }
        return null;
    }

    public function getRecipients($c=null)
    {
        if (!$this->aRecipients)
        {
            if ($c)
                $cr = clone $c;
            else
                $cr = new Criteria();
            
            $cr->add(MessageRecipientPeer::MESSAGE_ID, $this->id);
            if ($c) return MessageRecipientPeer::doSelectJoinRecipient($cr);
            else $this->aRecipients = MessageRecipientPeer::doSelectJoinRecipient($cr);
        }
        return $this->aRecipients;
    }
   
    public function getRecipientNames($c=null)
    {
        $recips = $this->getRecipients($c);
        $names = array();
        foreach($recips as $recip)
        {
            if ($recip)
                $names[] = $recip->getRecipient()->__toString();
        }
        return $names;
    }
   
    public function isSenderType($typ_id)
    {
        if ($this->sender_type_id==$typ_id) 
            return true;
        else
            return false;
    }

    public function hasMultipleRecipient()
    {
        if (!is_null($this->aRecipients)) return (count($this->aRecipients)>1);
        
        $c = new Criteria();
        $c->add(MessageRecipientPeer::MESSAGE_ID, $this->id);
        return (count(MessageRecipientPeer::doSelect($c)) > 1);
    }

    public function getRecipientFor($recipient_id, $recipient_type_id)
    {
        $c = new Criteria();
        $c->add(MessageRecipientPeer::RECIPIENT_ID, $recipient_id);
        $c->add(MessageRecipientPeer::RECIPIENT_TYPE_ID, $recipient_type_id);
        $rec = $this->getRecipients($c);
        return (count($rec)?$rec[0]:$rec); 
    }
    
    public function isDeliveredTo($recipient_id, $recipient_type_id)
    {
        return ($this->getRecipientFor($recipient_id, $recipient_type_id) ? true : false);
    }
    
    public function isReadBy($recipient_id, $recipient_type_id)
    {
        $rcp = $this->getRecipientFor($recipient_id, $recipient_type_id);
        return $rcp->getIsRead();
    }
    
    public function isSentBy($sender_id, $sender_type_id = PrivacyNodeTypePeer::PR_NTYP_USER)
    {
        return ($this->sender_id==$sender_id && $this->sender_type_id==$sender_type_id);
    }
    
    public function getOwner()
    {
        return $this->getSender();
    }
    
    public function bindRecipient($pos)
    {
        if ($this->getRecipientFor($rec->getId(), $rec->getObjectTypeId())) $this->_conversationRecipient = $rec;
    }
    
    public function getConversationRecipient()
    {
        return $this->_conversationRecipient;
    }

    public function getUrl($acc = null, $folder = null, $action = null)
    {
        return "@message-read?" . ($acc ? "acc={$acc->getPlug()}&" : '') . ($folder ? "folder=$folder&" : '') . ($action ? "_a=$action&" : '') . "_m={$this->getPlug()}";
    }
}
