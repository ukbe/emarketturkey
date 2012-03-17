<?php

class EmtAuthorObjectAction extends EmtObjectHandlerAction
{
    protected $_filter_author = true;
    protected $_owner_is_sesuser = false;
    protected $_allowed_acts = array('view', 'edit', 'new', 'rem', 'pub', 'unpub', 'rmp', 'ftr');
    
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);

        $this->author = $this->sesuser->getAuthor();
        
        if (!$this->author && $this->forceAuthor && !$this->sesuser->isNew())
        {
            $this->forward404("You don't have enough credentials.");
        }
        
        $this->objowner = $this->_owner_is_sesuser ? ($this->getUser()->hasCredential('editor') ? null : $this->sesuser) : ($this->_filter_author ? $this->author : null);

        $this->initObjectInterface();
    }

}