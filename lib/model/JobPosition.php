<?php

class JobPosition extends BaseJobPosition
{
    public function __toString()
    {
        return $this->getName(); 
    }

    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentJobPositionI18n($culture);
        return $lsi->isNew()?false:true;
    }
}
