<?php

class BusinessType extends BaseBusinessType
{
    public function __toString()
    {
        return $this->getName()!=''?$this->getName():$this->getName('en'); 
    }

    public function hasLsiIn($culture)
    {
        $lsi = $this->getCurrentBusinessTypeI18n($culture);
        return $lsi->isNew()?false:true;
    }
}
