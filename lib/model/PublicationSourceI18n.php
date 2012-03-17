<?php

class PublicationSourceI18n extends BasePublicationSourceI18n
{
    public function setDisplayName($displayname)
    {
        parent::setDisplayName($displayname);
        
        $this->setStrippedDisplayName(myTools::stripText($displayname));
    }
}
