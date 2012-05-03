<?php

class EmtMessageAction extends EmtManageAction
{
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->account = myTools::unplug($this->getRequestParameter('acc'));

        if ($this->account)
        {
            if (!$this->sesuser->isOwnerOf($this->account)) $this->redirect404();
        }

        $this->props = $this->sesuser->getOwnerships();

        $this->folder = myTools::pick_from_list($this->getRequestParameter('folder'), array('inbox', 'sent', 'archive'), 'inbox');
        
        $this->accparam = $this->account ? "acc={$this->account->getPlug()}" : "";
    }

}