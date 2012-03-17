<?php

class messageTemplatesAction extends EmtManageJobAction
{
    protected $enforceJob = false;
    
    public function handleAction($isValidationError)
    {
        $this->profile = $this->owner->getHRProfile();
        
        $this->ipps = array('extended'  => array(10, 20, 50));
        
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->status = myTools::pick_from_list($this->getRequestParameter('status'), array(UserJobPeer::UJ_STATUS_EVALUATING, UserJobPeer::UJ_STATUS_REJECTED, UserJobPeer::UJ_STATUS_EMPLOYED), null);
        $this->view = myTools::pick_from_list($this->getRequestParameter('view'), array('extended'), 'extended');
        $this->ipp = myTools::pick_from_list($this->getRequestParameter('ipp'), $this->ipps[$this->view], 20);

        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(JobMessageTemplatePeer::ID, JobMessageTemplateI18nPeer::ID);
            $c1 = $c->getNewCriterion(JobMessageTemplatePeer::NAME, "UPPER(".JobMessageTemplatePeer::NAME.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
            $c1->addOr($c->NewCriterion(JobMessageTemplatePeer::NAME, "UPPER(".JobMessageTemplatePeer::NAME.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM));
            $c->addAlias($c1);
            $c->setDistinct();
        }
        
        $this->pager = $this->profile->getMessageTemplatePager($this->page, $this->ipp, $c, $this->status);
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
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