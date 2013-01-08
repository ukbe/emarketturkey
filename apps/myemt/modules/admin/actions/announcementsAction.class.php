<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class announcementsAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->keyword = $this->getRequestParameter('keyword', '');
        $this->status = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('status')), array(ProductPeer::PR_STAT_APPROVED, ProductPeer::PR_STAT_EDITING_REQUIRED, ProductPeer::PR_STAT_PENDING_APPROVAL), ProductPeer::PR_STAT_APPROVED);
        $this->sort = myTools::pick_from_list($this->getRequestParameter('sort'), array('id', 'title', 'category', 'source', 'publish'), 'id');
        $this->dir = myTools::pick_from_list($this->getRequestParameter('dir'), array('asc', 'desc'), 'asc');
        $this->ipp = myTools::pick_from_list($this->getRequestParameter('ipp'), array(10, 20, 50, 100), 20);

        $c = new Criteria();
        if ($this->keyword)
        {
            $c->addJoin(AnnouncementPeer::ID, AnnouncementI18nPeer::ID);
            $c->add(AnnouncementI18nPeer::DISPLAY_TITLE, "UPPER(".AnnouncementI18nPeer::DISPLAY_TITLE.") LIKE UPPER('%".$this->keyword."%')", Criteria::CUSTOM);
        }

        $this->pager = AnnouncementPeer::getPagerFor(AnnouncementPeer::ANN_OWNER_BUILTIN, PrivacyNodeTypePeer::PR_NTYP_COMPANY, $this->page, $this->ipp, $c, $this->status);

    }

    public function validate()
    {
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}