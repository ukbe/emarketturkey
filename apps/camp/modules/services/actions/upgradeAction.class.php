<?php

class upgradeAction extends EmtAction
{
    public function execute($request)
    {
        if ($this->getRequestParameter('type') !== 'gold' && $this->getRequestParameter('type') !== 'platinum')
            $this->redirect('@premium-compare');
    }
    
    public function handleError()
    {
    }
    
}
