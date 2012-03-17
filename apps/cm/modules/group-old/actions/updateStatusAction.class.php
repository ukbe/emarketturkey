<?php

class updateStatusAction extends EmtAction
{
    
    public function execute($request)
    {
        if ($this->getRequestParameter('id'))
        {
            $group = GroupPeer::retrieveByPK($this->getRequestParameter('id'));
        }
        
        if (!$group) $this->redirect404();
                
        if ($this->hasRequestParameter('value'))
        {
            $group->setStatusUpdate($this->getRequestParameter('value'));
        }
        return $this->renderText($group->getStatusUpdate());
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