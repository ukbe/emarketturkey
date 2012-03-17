<?php

class coursesAction extends EmtCVObjectAction
{
    protected $_classname = 'ResumeCourse';
    protected $_collectionUrl = '@mycv-action?action=courses';
    
    public function execute($request)
    {
        $handleResult = $this->handleObjectActions($request);
        
        if ($handleResult != 'keep') return $handleResult;
        
        $this->course = $this->object;
        
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('commit') == $this->getRequestParameter('next'))
            {
                $this->redirect('@mycv-action?action=languages');
            }
            elseif ($this->getRequestParameter('commit') == $this->getRequestParameter('done'))
            {
                $this->redirect('@mycv-action?action=review');
            }
        }

        //  retrieve resume courses
        $c = new Criteria();
        $c->addDescendingOrderByColumn(ResumeCoursePeer::DATE_FROM);
        $this->courses = $this->resume->getResumeCourses($c);
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