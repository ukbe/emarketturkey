<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class photosAction extends EmtGroupAction
{
    public function execute($request)
    {
        return $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->getResponse()->setTitle($this->group . ' | eMarketTurkey');

        $this->albums = $this->group->getAlbums();
        $this->photos = $this->group->getPhotos();
        
        $c = new Criteria();
        $c->add(MediaItemPeer::FOLDER_ID, null, Criteria::ISNULL);
        $this->unclassified_num = $this->group->getPhotos($c, true);
        
        $this->ipps = array('thumbs' => array(9, 21, 45, 60));
        $this->page = is_numeric($this->getRequestParameter('page')) ? $this->getRequestParameter('page') : 1;
        $this->view = 'thumbs';
        $this->ipp = myTools::pick_from_list(myTools::fixInt($this->getRequestParameter('ipp')), $this->ipps[$this->view], 9);
        $this->album_id = myTools::fixInt($this->getRequestParameter('album'));
        $this->album = $this->album_id ? $this->group->getAlbum($this->album_id) : null;
        $this->unclassified = $this->getRequestParameter('album') == 'uc' || count($this->albums) == 0 ? true : false;
        $this->pid = $this->getRequestParameter('pid');
        $this->photo = $this->pid ? $this->group->getPhoto($this->pid) : null;

        if ($this->pid)
        {
            $this->photo = $this->group->getPhoto($this->pid);
            if (!$this->photo) 
            {
                $this->redirect404();
            }
            
            if ($this->getRequestParameter('act') == 'rm' && $this->own_group)
            {
                $album = $this->photo->getMediaItemFolder() ? 'album='.$this->photo->getFolderId() : (!$this->photo->getFolderId() ? 'album=uc' : '');
                $this->photo->delete();
                $this->redirect($album ? myTools::injectParameter($this->group->getProfileActionUrl('photos'), $album) : $this->group->getProfileActionUrl('photos'));
            }
            elseif ($this->getRequestParameter('act') == 'spl' && $this->own_group)
            {
                $con = Propel::getConnection();
                try {
                    $con->beginTransaction();
                    $existings = $this->group->getMediaItems(MediaItemPeer::MI_TYP_BANNER_IMAGE);
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
                $this->redirect($this->group->getProfileUrl());
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

        $this->pager = $this->group->getMediaItemPager($this->page, $this->ipp, $c, MediaItemPeer::MI_TYP_ALBUM_PHOTO);

        if (!$this->own_group) RatingPeer::logNewVisit($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY);

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