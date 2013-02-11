<?php

class CountryI18n extends BaseCountryI18n
{

    public function setName($name)
    {
        parent::setName($name);
        
        $this->setStrippedName(myTools::url_slug($name));
    }
    
}
