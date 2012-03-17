<?php

class EmtRouterAction extends EmtAction
{
    protected $ns = 'none';
    
    public function initialize($context, $moduleName, $actionName)
    {
        parent::initialize($context, $moduleName, $actionName);
        $settings = sfConfig::get('app_routerAction_'.$this->ns);
        $this->routingActions = $settings['actions'];
        $this->latestAction = $this->getUser()->getAttribute ('LATEST_ACTION', -1, $this->ns);
        if($this->getThisActionIndex() > ($this->latestAction + 1))
        {
            //$this->redirect($this->getModuleName() . '/' . $this->routingActions[$this->latestAction + 1]);
        }
        return true;
    }

    protected function getThisActionIndex()
    {
        $index = array_search(self::getActionName(), $this->routingActions);
        if($index === false)
        {
            return (count($this->routingActions) + 1); 
        }
        else
        {
            return $index;
        }
    }
	
	protected function setDataInSession()
	{
       $this->getUser()->setAttribute('LATEST_ACTION', $this->latestAction, $this->ns);
	}

    protected function updateLatestAction()
    {        
        $this->latestAction = $this->latestAction >= $this->getThisActionIndex() ? $this->latestAction : $this->getThisActionIndex();            
    }
    
    public function redirectToNextAction()
    {
		$this->updateLatestAction();
		$this->setDataInSession();
		$this->redirect($this->getModuleName().'/'.$this->routingActions[$this->getThisActionIndex()+1].'?id='.$this->resume->getId());
    }
    
    public function redirectToPreviousAction()
    {
		$this->latestAction = $this->getThisActionIndex() - 1;
		$this->setDataInSession();
		$this->redirect($this->getModuleName().'/'.$this->routingActions[$this->latestAction]);
    }
    
    
}

