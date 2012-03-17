<?php

class EmtConversation
{
    protected $_sender;
    protected $_recipient;
    protected $_object;
    protected $_last_query;
    protected $_reader;
    
    CONST READER_SENDER     = 1;
    CONST READER_RECIPIENT  = 2;
    
    public function __construct($sender, $recipient, $object = null, $reader = self::READER_RECIPIENT)
    {
        $this->_sender = $sender;
        $this->_recipient = $recipient;
        $this->_object = $object;
        $this->_reader = $reader;
    }
    
    public function getMessages($direction = MessagePeer::DIR_TWO_WAY, $page = 1)
    {
        return MessagePeer::getMessages($this->_sender, $this->_recipient, null, $this->_object, $direction, $reader == self::READER_SENDER ? false : null, $reader == self::READER_RECIPIENT ? false : null, $page);
    }

}
