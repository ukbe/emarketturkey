<?php

class EmtManageRoleAssetAction extends EmtManageAction
{
    protected $idKey = 'id';
    protected $acts = array('new', 'edit', 'rem', 'pub', 'unpub');
    protected $act = null;
    protected $itemClass = null;
    protected $retItemFunc = 'retrieveByPK';

    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->author = $this->sesuser->getAuthor();
        
        if (!$this->author && $this->forceAuthor && !$this->sesuser->isNew())
        {
            $this->forward404("You don't have enough credentials.");
        }
    }
    
}