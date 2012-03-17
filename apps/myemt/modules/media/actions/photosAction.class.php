<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class photosAction extends EmtAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if ($this->getRequestParameter('id'))
        {
            $this->user = UserPeer::retrieveByPK($this->getRequestParameter('id'));
        }
        else
        {
            $this->user = $this->getUser()->getUser();
        }
        if (!$this->user || 
            ($this->user->getId() != $this->getUser()->getUser()->getId() &&
             !$this->getUser()->getUser()->can(ActionPeer::ACT_VIEW_PROFILE, $this->user)))
        { 
            $this->redirect('@homepage');
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                
            }
        }
        else
        {
            if ($this->getRequest()->hasParameter('pid'))
            {
                if (is_numeric($this->getRequestParameter('pid', -1)))
                {
                    $this->photo = $this->user->getPhoto($this->getRequestParameter('pid'));
                    if ($this->photo) 
                    {
                        if ($this->getRequestParameter('mod')=='display')
                        {
                            if ($this->user->getId() == $this->getUser()->getUser()->getId())
                            {
                                $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("My Photo | eMarketTurkey"));
                                
                                $this->setTemplate('display');return;
                            }
                            else
                            {
                                $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("%1's Photo | eMarketTurkey", array('%1' => $this->user)));
                                $this->setTemplate('otherUserDisplay');return;
                            }
                        }
                        elseif ($this->getRequestParameter('mod')=='delete')
                        {
                            if ($this->user->getId() == $this->getUser()->getUser()->getId())
                            {
                                $this->photo->delete();
                                $this->getUser()->setMessage('Photo Deleted', 'Your photo was deleted successfully!', null, null, false);
                                $this->redirect('media/photos');
                            }
                        }
                        elseif ($this->getRequestParameter('mod')=='setprofile')
                        {
                            if ($this->user->getId() == $this->getUser()->getUser()->getId())
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
            $this->photos = $this->user->getMediaItems(MediaItemPeer::MI_TYP_ALBUM_PHOTO);
        }

        if ($this->user->getId() != $this->getUser()->getUser()->getId())
        {
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("%1's Photos | eMarketTurkey", array('%1' => $this->user)));
            $this->setTemplate('otherUserPhotos');
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