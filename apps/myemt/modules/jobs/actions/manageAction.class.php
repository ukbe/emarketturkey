<?php

class manageAction extends EmtManageJobAction
{
    protected $enforceJob = false;
    
    public function execute($request)
    {
        $this->ipps = array('extended'  => array(10, 20, 50),
                            'list'      => array(10, 20, 50, 100),
                            'thumbs'    => array(20, 50, 100, 150)
                        );
        
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->status = myTools::pick_from_list($this->getRequestParameter('status'), array(JobPeer::JSTYP_ONLINE, JobPeer::JSTYP_OFFLINE, JobPeer::JSTYP_SUSPENDED, JobPeer::JSTYP_OBSOLETE), JobPeer::JSTYP_ONLINE);
        $this->view = myTools::pick_from_list($this->getRequestParameter('view'), array('extended', 'list', 'thumbs'), 'list');
        $this->ipp = myTools::pick_from_list($this->getRequestParameter('ipp'), $this->ipps[$this->view], 20);
        $this->jfunc = is_numeric($this->getRequestParameter('jfunc')) ? JobFunctionPeer::retrieveByPK($this->getRequestParameter('jfunc')) : null;

        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(JobPeer::ID, JobI18nPeer::ID);
            $c->add(JobI18nPeer::DISPLAY_TITLE, "UPPER(".JobI18nPeer::DISPLAY_TITLE.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
            $c->addOr(JobI18nPeer::DESCRIPTION, "UPPER(".JobI18nPeer::DESCRIPTION.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
            $c->addOr(JobI18nPeer::REQUIREMENTS, "UPPER(".JobI18nPeer::REQUIREMENTS.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
            $c->addOr(JobI18nPeer::RESPONSIBILITY, "UPPER(".JobI18nPeer::RESPONSIBILITY.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
        }
        
        if ($this->jfunc)
        {
            $c->addJoin(JobPeer::ID, JobSpecPeer::JOB_ID);
            $c->add(JobSpecPeer::TYPE_ID, JobSpecPeer::JSPTYP_JOB_FUNCTION);
            $c->add(JobSpecPeer::SPEC_ID, $this->jfunc->getId());
        }
        
        $this->pager = $this->owner->getJobPager($this->page, $this->ipp, $c, $this->status);

        $this->used_items = PurchasePeer::getUsedItemsFor($this->owner->getId(), $this->otyp, ServicePeer::STYP_JOB_ANNOUNCEMENT, true);
        $this->purchased_items = PurchasePeer::getPurchasedItemCountFor($this->owner->getId(), $this->otyp, ServicePeer::STYP_JOB_ANNOUNCEMENT, true);

    }
    
    public function handleError()
    {
    }
    
}
