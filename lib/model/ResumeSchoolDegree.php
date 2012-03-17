<?php

class ResumeSchoolDegree extends BaseResumeSchoolDegree
{
    public function __toString()
    {
        return $this->getName(); 
    }
}
