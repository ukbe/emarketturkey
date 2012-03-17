<?php

class ProductGroupI18n extends BaseProductGroupI18n
{
    public function setName($name)
    {
        parent::setName($name);
        
        $this->setStrippedName(myTools::stripText($name));
    }
    
}
