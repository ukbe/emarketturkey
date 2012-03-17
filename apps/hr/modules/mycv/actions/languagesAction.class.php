<?php

class languagesAction extends EmtCVObjectAction
{
    protected $_classname = 'ResumeLanguage';
    protected $_collectionUrl = '@mycv-action?action=languages';
    
    public function execute($request)
    {
        $handleResult = $this->handleObjectActions($request);
        
        if ($handleResult != 'keep') return $handleResult;
        
        $this->language = $this->object;
                
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('commit') == $this->getRequestParameter('next'))
            {
                $this->redirect('@mycv-action?action=publications');
            }
            elseif ($this->getRequestParameter('commit') == $this->getRequestParameter('done'))
            {
                $this->redirect('@mycv-action?action=review');
            }
        }

        //  retrieve resume languages
        $this->languages = $this->resume->getResumeLanguages();
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