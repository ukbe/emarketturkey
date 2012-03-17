<?php

class BusinessSectorI18n extends BaseBusinessSectorI18n
{
    public function setName($name)
    {
        parent::setName($name);
        
        $this->setStrippedName(myTools::stripText($name));
    }
}
