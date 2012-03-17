<?php

class routeAction extends EmtAction
{
    public function execute($request)
    {
        $this->user = $this->getUser()->getUser();
        
        if (!$this->user) $this->redirect('@lobby.homepage');
        
        $this->group = $this->user->getGroupById($this->getRequestParameter('id'));
        
        if (!$this->group) $this->redirect('@lobby.homepage');
    }
}
