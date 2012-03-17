<?php

class settingsAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        $this->profile = $this->company->getCompanyProfile();
        $this->people = $this->company->getPeople();
    }
    
    public function handleError()
    {
    }
    
}