<?php

class announcementAction extends EmtAdminObjectAction
{
    protected $_classname = "Announcement";
    protected $_collectionUrl = "@admin-action?action=announcements";

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
    }
    
    public function execute($request)
    {
        $handleResult = $this->handleObjectActions($request);
        
        if ($handleResult != 'keep') return $handleResult;

        switch ($this->act)
        {
            case 'new' : 
                $this->getResponse()->setTitle('New Announcement | eMarketTurkey');
                break;
            case 'edit' :
                $this->getResponse()->setTitle('Edit Announcement | eMarketTurkey');
                break;
            case 'view' :
                $this->getResponse()->setTitle('Review Announcement | eMarketTurkey');
                break;
        }
        
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
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
