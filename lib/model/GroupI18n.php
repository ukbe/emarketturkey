<?php

class GroupI18n extends BaseGroupI18n
{
    public function setDisplayName($name)
    {
        parent::setDisplayName($name);
        
        $this->setStrippedDisplayName(myTools::url_slug($name));
    }
}
