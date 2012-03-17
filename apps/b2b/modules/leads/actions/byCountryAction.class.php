<?php

class byCountryAction extends EmtAction
{
    public function execute($request)
    {
        $types = array('selling' => B2bLeadPeer::B2B_LEAD_SELLING, 'buying' => B2bLeadPeer::B2B_LEAD_BUYING);
        $this->type_code = myTools::pick_from_list($this->getRequestParameter('type_code'), array_keys($types), null);
        $this->type_id = in_array($this->type_code, array_keys($types)) ? $types[$this->type_code] : null;
        if (!$this->type_id) $this->redirect('@homepage');
        $this->isbuying = $this->type_id == B2bLeadPeer::B2B_LEAD_BUYING;
        
        $this->countries = CountryPeer::getOrderedNames();
    }

    public function handleError()
    {
    }

}
