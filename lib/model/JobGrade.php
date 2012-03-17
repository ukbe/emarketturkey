<?php

class JobGrade extends BaseJobGrade
{
    public function __toString()
    {
        return $this->getName(); 
    }

    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentJobGradeI18n($culture);
        return $lsi->isNew()?false:true;
    }
}
