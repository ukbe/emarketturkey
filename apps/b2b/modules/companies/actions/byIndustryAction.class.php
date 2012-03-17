<?php

class byIndustryAction extends EmtAction
{
    public function execute($request)
    {
        $this->industries = BusinessSectorPeer::getOrderedNames();
    }

    public function handleError()
    {
    }

}
