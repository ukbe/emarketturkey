<?php

class PublicationCategoryI18n extends BasePublicationCategoryI18n
{
    public function setName($name)
    {
        parent::setName($name);
        
        $this->setStrippedCategory(myTools::stripText($name));
    }
}
