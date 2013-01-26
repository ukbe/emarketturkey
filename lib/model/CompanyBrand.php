<?php

class CompanyBrand extends BaseCompanyBrand
{
    public function __toString()
    {
        return $this->getName();
    }
    
}
