<?php

class workAction extends EmtCVObjectAction
{
    protected $_classname = 'ResumeWork';
    protected $_collectionUrl = '@mycv-action?action=work';
    
    public function execute($request)
    {
        $handleResult = $this->handleObjectActions($request);
        
        if ($handleResult != 'keep') return $handleResult;
        
        $this->work = $this->object;
        
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('commit') == $this->getRequestParameter('next'))
            {
                $this->redirect('@mycv-action?action=courses');
            }
            elseif ($this->getRequestParameter('commit') == $this->getRequestParameter('done'))
            {
                $this->redirect('@mycv-action?action=review');
            }
        }

        //  retrieve resume works
        $c = new Criteria();
        $c->addDescendingOrderByColumn(ResumeWorkPeer::DATE_FROM);
        $this->works = $this->resume->getResumeWorks($c);
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