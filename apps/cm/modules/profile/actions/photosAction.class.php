<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class photosAction extends EmtUserAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if (
                (!$this->sesuser->can(ActionPeer::ACT_VIEW_PROFILE, $this->user) && !$this->sesuser->can(ActionPeer::ACT_VIEW_PUBLIC_PROFILE, $this->user))
                ||
                !$this->sesuser->can(ActionPeer::ACT_VIEW_PHOTOS, $this->user)
            )
        { 
            $this->setTemplate('lockedProfile');
            return sfView::SUCCESS;
        }        
        
        if ($this->getRequest()->hasParameter('pid'))
        {
            if (is_numeric($this->getRequestParameter('pid', -1)))
            {
                $this->photo = $this->user->getPhoto($this->getRequestParameter('pid'));
                if ($this->photo) 
                {
                    if ($this->getRequestParameter('mod')=='display')
                    {
                        if ($this->user->getId() == $this->sesuser->getId())
                        {
                            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("My Photo | eMarketTurkey"));
                        }
                        else
                        {
                            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("%1's Photo | eMarketTurkey", array('%1' => $this->user)));
                        }
                        $this->setTemplate('display');return;
                    }
                    elseif ($this->getRequestParameter('mod')=='delete')
                    {
                        if ($this->user->getId() == $this->sesuser->getId())
                        {
                            $this->photo->delete();
                            $this->getUser()->setMessage('Photo Deleted', 'Your photo was deleted successfully!', null, null, false);
                            $this->redirect($this->user->getPhotosUrl());
                        }
                    }
                    elseif ($this->getRequestParameter('mod')=='setprofile')
                    {
                        if ($this->user->getId() == $this->sesuser->getId())
                        {
                            $profile = $this->user->setProfilePictureId($this->photo->getId());

                            $this->getUser()->setMessage('New Profile Picture', 'Your photo was set as profile picture', null, null, false);
                            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("New Profile Photo | eMarketTurkey"));
                            $this->setTemplate('display');
                            return;
                        }
                    }
                }
            }
            $this->redirect404();
        }
        if (($aid = $this->getRequestParameter('aid')) &&  is_numeric($aid) && ($this->album=$this->user->getFolder($aid, MediaItemPeer::MI_TYP_ALBUM_PHOTO)))
        {
            $this->albums = array();
            $c = new Criteria();
            $c->add(MediaItemPeer::FOLDER_ID, $aid);
            $c->addAscendingOrderByColumn(MediaItemPeer::CREATED_AT);
            $this->photos = $this->user->getPhotos($c);
        }
        else
        {
            $this->albums = $this->user->getAlbums();
            $c = new Criteria();
            $c->add(MediaItemPeer::FOLDER_ID, null, Criteria::ISNULL);
            $c->addAscendingOrderByColumn(MediaItemPeer::CREATED_AT);
            $this->photos = $this->user->getPhotos($c);
        }

        if ($this->user->getId() != $this->sesuser->getId())
        {
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("%1's Photos | eMarketTurkey", array('%1' => $this->user)));
        }

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