<?php

class UserJob extends BaseUserJob
{
    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_USER_JOB;
    }

    public function setStatus($status_id, $notify = null, $template_id = null)
    {
        $eligible = true; // prepare this var to provide ability to change app status to new situation
        
        if ($eligible)
        {
            $this->setStatusId($status_id);
            $this->save();
            
            // Setup Email Transaction to notify applicant
            if ($notify && ($template = $this->getJob()->getOwner()->getHRProfile()->getMessageTemplateById($template_id)) && ($template->getTypeId() == $status_id || is_null($template->getTypeId())))
            {
                $ln = $this->getUser()->getPreferredCulture($template->getDefaultLang());
                $message = str_replace(array("\n", "#uname", "#oname", "#joblink", "#jobtitle") , array("<br />", $this->getUser(), '<strong>'.$this->getJob()->getOwner()->getHrProfile()->getName().'</strong>', '<a href="'.$this->getJob()->getUrl().'">'.$this->getJob()->getDisplayTitle($ln).'</a>', $this->getJob()->getDisplayTitle($ln)), $template->getClob(JobMessageTemplateI18nPeer::CONTENT, $ln));
                
                MessagePeer::createMessage($this->getJob()->getOwner(),
                                           array(PrivacyNodeTypePeer::PR_NTYP_USER => array($this->getUser()->getId())),
                                           $template->getTitle($ln),
                                           $message, null, $this->getId(), PrivacyNodeTypePeer::PR_NTYP_USER_JOB);
                
            }
            
            return true;
        }
        return false;
    }
    
    public function getResumeFolder()
    {
        $folders = $this->getUser()->getResume()->getClassifiedResumes();
        return count($folders) ? $folders[0]->getResumeFolder() : null;
    }
    
    public function getMessagings($direction = MessagePeer::DIR_TWO_WAY)
    {
        return MessagePeer::getMessages($this->getJob()->getOwner(), $this->getUser(), null, $this, $direction, null, false);
    }
}
