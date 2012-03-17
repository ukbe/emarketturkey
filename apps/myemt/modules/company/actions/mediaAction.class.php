<?php

class mediaAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        $this->media_items = $this->company->getMediaItems();
    }
    
    public function handleError()
    {
    }
    
}
