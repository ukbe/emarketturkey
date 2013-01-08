<?php

class bookmarksAction extends EmtCVAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['action']);
        unset($params['sf_culture']);
        $this->redirect("@camp.mycareer-action?".http_build_query($params), 301);

        $this->fav_books = $this->sesuser->getBookmarkByItem(null, null, UserBookmarkPeer::BMTYP_FAVOURITE);

        $c = new Criteria();
        $c->addDescendingOrderByColumn(UserJobPeer::CREATED_AT);
        $c->setLimit(5);
        $this->fav_ujobs = $this->sesuser->getUserJobsByTypeId(UserJobPeer::UJTYP_FAVOURITE, false, $c);

        $c = new Criteria();
        $c->addDescendingOrderByColumn(UserJobPeer::CREATED_AT);
        $c->setLimit(5);
        $this->app_ujobs = $this->sesuser->getUserJobsByTypeId(UserJobPeer::UJTYP_APPLIED, false, $c);
    }
    
    public function handleError()
    {
    }
    
}
