<?php

class groupsAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        if ($this->getRequestParameter('act') == 'rmg' && ($group = $this->company->getProductGroupById($this->getRequestParameter('gid'))))
        {
            $group->delete();
            if ($this->refUrl) $this->redirect($this->refUrl);
        }
        
        $this->groups = $this->company->getProductGroups();
    }

    public function handleError()
    {
    }

}
