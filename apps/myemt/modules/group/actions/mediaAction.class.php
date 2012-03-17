<?php

class mediaAction extends EmtGroupAction
{
    protected $actionID = ActionPeer::ACT_MANAGE_GROUP;
    
    public function execute($request)
    {
        if (!$this->goodToRun) $this->redirect404();
        
        $this->media_items = $this->group->getMediaItems();
        
    }
    
    public function handleError()
    {
    }
    
}
