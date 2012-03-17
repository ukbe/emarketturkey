<?php

class ResumeFolder extends BaseResumeFolder
{
    public function __toString()
    {
        return $this->getName(); 
    }
    
    public function getResumes($return_count = false)
    {
        $c = new Criteria();
        $c->addJoin(ResumePeer::ID, ClassifiedResumePeer::RESUME_ID, Criteria::LEFT_JOIN);
        $c->add(ClassifiedResumePeer::FOLDER_ID, $this->getId());
        return $return_count ? ResumePeer::doCount($c) : ResumePeer::doSelect($c);
    }
}
