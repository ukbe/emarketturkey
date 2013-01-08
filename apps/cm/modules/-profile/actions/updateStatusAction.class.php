<?php

class updateStatusAction extends EmtUserAction
{
    
    public function execute($request)
    {
        $user = $this->sesuser;
        
        if ($this->hasRequestParameter('value'))
        {
            $user->setStatusUpdate($this->getRequestParameter('value'));
        }
        if ($this->getRequest()->isXmlHttpRequest())
            return $this->renderText($user->getStatusUpdate());
        else
            $this->getRequestParameter('ref')!='' ? $this->redirect($this->getRequestParameter('ref')) : $this->redirect($this->getRequest()->getReferrer());
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