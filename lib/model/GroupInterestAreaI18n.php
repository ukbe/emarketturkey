<?php

class GroupInterestAreaI18n extends BaseGroupInterestAreaI18n
{
    public function setName($name)
    {
        parent::setName($name);
        
        $this->setStrippedName(myTools::stripText($name));
    }
}
