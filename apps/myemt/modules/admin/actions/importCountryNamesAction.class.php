<?php

class importCountryNamesAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
                $cults = sfCultureInfo::getInstance(sfContext::getInstance()->getUser()->getCulture())->getLanguages(array('en'));
        $ln = 0;
        $es = array();
        foreach ($cults as $lang => $language)
        {
            $ln++;
            $cc = 0;
            try {
            $inst = sfCultureInfo::getInstance($lang);
            }
            catch (Exception $e)
            {
                $es[] = $e->getMessage();
                $countries = array();
                continue;
            }
            foreach ($inst->getCountries() as $iso => $country)
            {
                $cc++;
                $cnt = CountryPeer::retrieveByISO($iso);
                if (!$cnt)
                {
                    $cnt = new Country();
                    $cnt->setIso($iso);
                    $cnt->save();
                }
                $cnt->setName($country, $lang);
                $cnt->save();
            }
        }
        echo "saved $cc countries in $ln languages";
        echo "<br />errors:<br />".implode('<br />', $es);
        die;
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {   
        return !$this->getRequest()->hasErrors();
    }
}
