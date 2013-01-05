<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class photosAction extends EmtCompanyAction
{
    public function execute($request)
    {
        // Redirect to camp application
        $params = $this->getRequest()->getParameterHolder()->getAll();
        unset($params['module']);
        unset($params['sf_culture']);
        $this->redirect("@camp.company-profile-action?".http_build_query($params), 301);

        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->getResponse()->setTitle($this->company->getName() . ' | eMarketTurkey');

        $this->albums = $this->company->getAlbums();
        $this->photos = $this->company->getPhotos();
        
        $c = new Criteria();
        $c->add(MediaItemPeer::FOLDER_ID, null, Criteria::ISNULL);
        $this->unclassified_num = $this->company->getPhotos($c, true);
        
        $this->ipps = array('thumbs' => array(9, 21, 45, 60));
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->view = 'thumbs';
        $this->ipp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ipp')), $this->ipps[$this->view], 9);
        $this->album_id = myTools::fixInt($this->getRequestParameter('album'));
        $this->album = $this->album_id ? $this->company->getAlbum($this->album_id) : null;
        $this->unclassified = $this->getRequestParameter('album') == 'uc' || count($this->albums) == 0 ? true : false;
        $this->pid = $this->getRequestParameter('pid');
        $this->photo = $this->pid ? $this->company->getPhoto($this->pid) : null;

        if ($this->pid)
        {
            $this->photo = $this->company->getPhoto($this->pid);
            if (!$this->photo) 
            {
                $this->redirect404();
            }
            
            if ($this->getRequestParameter('act') == 'rm' && $this->own_company)
            {
                $album = $this->photo->getMediaItemFolder() ? 'album='.$this->photo->getFolderId() : (!$this->photo->getFolderId() ? 'album=uc' : '');
                $this->photo->delete();
                $this->redirect($album ? myTools::injectParameter($this->company->getProfileActionUrl('photos'), $album) : $this->company->getProfileActionUrl('photos'));
            }
            elseif ($this->getRequestParameter('act') == 'spl' && $this->own_company)
            {
                $con = Propel::getConnection();
                try {
                    $con->beginTransaction();
                    $existings = $this->company->getMediaItems(MediaItemPeer::MI_TYP_BANNER_IMAGE);
                    foreach ($existings as $ex)
                    {
                        $ex->setItemTypeId(MediaItemPeer::MI_TYP_ALBUM_PHOTO);
                        $ex->save();
                    }
                    $this->photo->setItemTypeId(MediaItemPeer::MI_TYP_BANNER_IMAGE);
                    $this->photo->save();
                    $con->commit();
                }
                catch (Exception $e)
                {
                    $con->rollBack();
                }
                $this->redirect($this->company->getProfileUrl());
            }
            
            $this->setTemplate('displayPhoto');
        }

        $c = new Criteria();
        if ($this->album)
        {
            $c->add(MediaItemPeer::FOLDER_ID, $this->album->getId());
        }
        elseif ($this->unclassified)
        {
            $c->add(MediaItemPeer::FOLDER_ID, null, Criteria::ISNULL);
        }

        $this->pager = $this->company->getMediaItemPager($this->page, $this->ipp, $c, MediaItemPeer::MI_TYP_ALBUM_PHOTO);

        if (!$this->own_company) RatingPeer::logNewVisit($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY);

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