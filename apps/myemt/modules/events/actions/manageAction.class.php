<?php

class manageAction extends EmtManageEventAction
{
    protected $enforceEvent = false;
    
    public function execute($request)
    {
        $this->ipps = array('extended'  => array(10, 20, 50),
                            'list'      => array(10, 20, 50, 100),
                            'thumbs'    => array(20, 50, 100, 150)
                        );
        
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->status = myTools::pick_from_list($this->getRequestParameter('status'), array(ProductPeer::PR_STAT_APPROVED, ProductPeer::PR_STAT_EDITING_REQUIRED, ProductPeer::PR_STAT_PENDING_APPROVAL), ProductPeer::PR_STAT_APPROVED);
        $this->view = myTools::pick_from_list($this->getRequestParameter('view'), array('extended', 'list', 'thumbs'), 'list');
        $this->ipp = myTools::pick_from_list($this->getRequestParameter('ipp'), $this->ipps[$this->view], 20);

        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(EventPeer::ID, EventI18nPeer::ID);
            $c->add(EventI18nPeer::NAME, "UPPER(".EventI18nPeer::NAME.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
            $c->addOr(EventI18nPeer::INTRODUCTION, "UPPER(".EventI18nPeer::INTRODUCTION.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
        }
        
        $this->pager = $this->owner->getEventsPager($this->page, $this->ipp, $c, $this->status);

    }

    public function handleError()
    {
    }

}
