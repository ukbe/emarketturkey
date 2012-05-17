<?php

class allBCAction extends EmtAction
{
    public function execute($request)
    {
        if ($this->hasRequestParameter('stripped_title'))
        {
            $pmodule = $this->getRequestParameter('pmodule');
            $paction = $this->getRequestParameter('paction');

            if ($pmodule == 'corporate' && $paction == 'forSuppliers')
            {
                $this->redirect('@for-suppliers', 301);
            }
            elseif ($pmodule == 'corporate' && $paction == 'forIndividuals')
            {
                $this->redirect('@for-individuals', 301);
            }
        }
        $this->redirect404();
    }
    
    public function handleError()
    {
    }
    
}