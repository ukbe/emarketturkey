<?php

class basicAction extends EmtCVAction
{
    private function handleAction($isValidationError)
    {
        $this->profile = $this->sesuser->getUserProfile();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                $this->resume->setTitle($this->getRequestParameter('rsmtitle'));
                $this->resume->setJobPositionId($this->getRequestParameter('rsmpositionid'));
                $this->resume->setJobGradeId($this->getRequestParameter('rsmjobgradeid'));
                $this->resume->setObjective($this->getRequestParameter('rsmobjective'));
                $this->resume->save();

                if ($this->getRequestParameter('commit') == $this->getRequestParameter('next'))
                {
                    $this->redirect('@mycv-action?action=contact');
                }
                elseif ($this->getRequestParameter('commit') == $this->getRequestParameter('done'))
                {
                    $this->redirect('@mycv-action?action=review');
                }
            }
            else
            {
                // error, so display form again
                return sfView::SUCCESS;
            }
        }
    }
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }
    
}
