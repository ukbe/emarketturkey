<?php

class importProductsAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $currentlinks = $this->getUser()->getAttribute('links', array(), 'product-info-grabber');
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && $this->getRequestParameter('product-list-source') != '')
        {
            if ($this->getRequestParameter('list-type') == 'XML' && $this->getRequestParameter('link-node'))
            {
                $xml = simplexml_load_string($this->getRequestParameter('product-list'));
                $links = array_diff($xml->children($this->getRequestParameter('link-node')), $currentlinks);
            }
            elseif ($this->getRequestParameter('list-type') == 'TEXT')
            {
                $links = array_diff(explode("\n", $this->getRequestParameter('product-list-source')), $currentlinks);
            }
            else
            {
                $this->message = "Incorrect input! Please try again.";
                return sfView::SUCCESS;
            }
            
            if (count($links))
            {
                $this->newlinks = count($links);
                $this->getUser()->setAttribute('links', array_merge($currentlinks, $links), 'product-info-grabber');
            }
        }
    }
    
    public function execute($request)
    {
         return $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
}
