<?php

class employersAction extends EmtCVAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $group = myTools::pick_from_list($this->getRequestParameter('group'), array('banned', 'bookmarked'), null);

        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['action']);
        unset($params['sf_culture']);
        if ($group == 'bookmarked')
            $this->redirect("@camp.myemployers-bookmarked?".http_build_query($params), 301);
        elseif ($group == 'banned')
            $this->redirect("@camp.myemployers-banned?".http_build_query($params), 301);
        else
            $this->redirect("@camp.myemployers?".http_build_query($params), 301);

        $this->group = myTools::pick_from_list($this->getRequestParameter('group'), array('banned', 'bookmarked'), 'bookmarked');
        $this->page = myTools::fixInt($this->getRequestParameter('page'));
        
        $c = new Criteria();
        $c->add(UserBookmarkPeer::USER_ID, $this->sesuser->getId());
        $c->add(UserBookmarkPeer::TYPE_ID, $this->group == 'banned' ? UserBookmarkPeer::BMTYP_BANNED : UserBookmarkPeer::BMTYP_FAVOURITE);
        $c->addDescendingOrderByColumn(UserBookmarkPeer::CREATED_AT);

        $this->pager = new sfPropelPager('UserBookmark', 10);
        $this->pager->setCriteria($c);
        $this->pager->setPage($this->page);
        $this->pager->init();
    }
    
    public function handleError()
    {
    }
    
}
