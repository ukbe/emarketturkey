<?php

class updateStatusAction extends EmtAction
{
    
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect("@camp.group-profile?stripped_name={$this->group->getStrippedName()}", 301);

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