<?php

class referencesAction extends EmtCVObjectAction
{
    protected $_classname = 'ResumeReference';
    protected $_collectionUrl = '@mycv-action?action=references';
    
    public function execute($request)
    {
        $handleResult = $this->handleObjectActions($request);
        
        if ($handleResult != 'keep') return $handleResult;
        
        $this->reference = $this->object;
        
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('commit') == $this->getRequestParameter('next'))
            {
                $this->redirect('@mycv-action?action=organisations');
            }
            elseif ($this->getRequestParameter('commit') == $this->getRequestParameter('done'))
            {
                $this->redirect('@mycv-action?action=review');
            }
        }

        //  retrieve resume references
        $this->references = $this->resume->getResumeReferences();
    }

    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}