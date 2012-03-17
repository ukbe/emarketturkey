<?php

class overviewAction extends EmtAuthorAction
{
    protected $forceAuthor = true;

    public function execute($request)
    {
        if (!$this->author)
        {
            $this->setTemplate('createAuthorAccount');
        }
    }
    
    public function handleError()
    {
    }
    
}
