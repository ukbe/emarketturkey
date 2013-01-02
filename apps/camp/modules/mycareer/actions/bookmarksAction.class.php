<?php

class bookmarksAction extends EmtCVAction
{
    public function execute($request)
    {
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
