<?php

class AuthorI18n extends BaseAuthorI18n
{
    public function setDisplayName($displayname)
    {
        parent::setDisplayName($displayname);
        
        $this->setStrippedDisplayName(myTools::url_slug($displayname));
    }
}
