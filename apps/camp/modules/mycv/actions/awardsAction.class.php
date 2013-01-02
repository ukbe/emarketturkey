<?php

class awardsAction extends EmtCVObjectAction
{
    protected $_classname = 'ResumeAward';
    protected $_collectionUrl = '@mycv-action?action=awards';
    
    public function execute($request)
    {
        $handleResult = $this->handleObjectActions($request);
        
        if ($handleResult != 'keep') return $handleResult;
        
        $this->award = $this->object;
        
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('commit') == $this->getRequestParameter('next'))
            {
                $this->redirect('@mycv-action?action=references');
            }
            elseif ($this->getRequestParameter('commit') == $this->getRequestParameter('done'))
            {
                $this->redirect('@mycv-action?action=review');
            }
        }

        //  retrieve resume awards
        $c = new Criteria();
        $c->addDescendingOrderByColumn(ResumeAwardPeer::YEAR);
        $this->awards = $this->resume->getResumeAwards($c);
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