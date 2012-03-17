<?php

class PublicationI18n extends BasePublicationI18n
{
    public function setTitle($title)
    {
        parent::setTitle($title);
        
        $this->setStrippedTitle(myTools::stripText($title));
    }
}
