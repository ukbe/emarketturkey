<?php

class EventInvite extends BaseEventInvite
{
    protected $subject = null;
    
    public function getSubject()
    {
        if (!isset($this->subject)){
            $this->subject = PrivacyNodeTypePeer::retrieveObject($this->getSubjectId(), $this->getSubjectTypeId());
            $this->subject = !($this->subject) ? 'NA' : $this->subject;
            return $this->subject;
        }
        else
        {
            return $this->subject !== 'NA' ? $this->subject : null;
        }
    }
}
