<?php

class JobLocation extends BaseJobLocation
{
    public function __toString()
    {
        return $this->formatText(':'); 
    }

    public function formatText($format = ':')
    {
        $culture = sfContext::getInstance()->getUser()->getCulture();

        sfLoader::loadHelpers('I18N');

        $arr = array();

        switch ($format)
        {
            case ':' : return ($this->getGeonameCity() ? $this->getGeonameCity()->getName() : '') 
                             .($this->getGeonameCity() ? '(' . format_country($this->getCountryCode(), $culture) . ')' : format_country($this->getCountryCode(), $culture)) . ' '
                              .format_number_choice('[1]1 personel|(1,+Inf]%1 personels', array('%1' => $this->getNoOfStaff()), $this->getNoOfStaff());
            case '@' : return  $this->getNoOfStaff() . ' @ ' . ($this->getGeonameCity() ? $this->getGeonameCity()->getName() : '') 
                             .($this->getGeonameCity() ? '(' . format_country($this->getCountryCode(), $culture) . ')' : format_country($this->getCountryCode(), $culture));
        }
    }

}
