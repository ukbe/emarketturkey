<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class photosAction extends EmtGroupAction
{
    protected $actionID = ActionPeer::ACT_VIEW_PHOTOS;
    
    public function execute($request)
    {
        // Redirect to camp application
        $this->redirect("@camp.group-profile-action?action=photos&stripped_name={$this->group->getStrippedName()}", 301);

        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if (!$this->sesuser->can(ActionPeer::ACT_VIEW_PHOTOS, $this->group))
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
                    $this->photo = $this->group->getPhoto($this->getRequestParameter('pid'));
                    if ($this->photo) 
                    {
                        if ($this->getRequestParameter('mod')=='display')
                        {
                            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("%1's Photo | eMarketTurkey", array('%1' => $this->group)));
                            $this->setTemplate('display');return;
                        }
                        elseif ($this->getRequestParameter('mod')=='delete')
                        {
                            if ($this->sesuser->isOwnerOf($this->group))
                            {
                                $this->photo->delete();
                                $this->getUser()->setMessage('Photo Deleted', 'Group photo was deleted successfully!', null, null, false);
                                $this->redirect('@group-action?action=photos&stripped_name='.$this->group->getStrippedName());
                            }
                        }
                        elseif ($this->getRequestParameter('mod')=='setprofile')
                        {
                            if ($this->sesuser->isOwnerOf($this->group))
                            {
                                $profile = $this->group->setProfilePictureId($this->photo->getId());

                                $this->getUser()->setMessage('New Profile Picture', 'Group photo was set as profile picture', null, null, false);
                                $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("New Profile Photo | eMarketTurkey"));
                                $this->setTemplate('display');
                                return;
                            }
                        }
                    }
                }
                $this->redirect404();
            }
            if (($aid = $this->getRequestParameter('aid')) &&  is_numeric($aid) && ($this->album=$this->group->getFolder($aid, MediaItemPeer::MI_TYP_ALBUM_PHOTO)))
            {
                $this->albums = array();
                $c = new Criteria();
                $c->add(MediaItemPeer::FOLDER_ID, $aid);
                $c->addAscendingOrderByColumn(MediaItemPeer::CREATED_AT);
                $this->photos = $this->group->getPhotos($c);
            }
            else
            {
                $this->albums = $this->group->getAlbums();
                $c = new Criteria();
                $c->add(MediaItemPeer::FOLDER_ID, null, Criteria::ISNULL);
                $c->addAscendingOrderByColumn(MediaItemPeer::CREATED_AT);
                $this->photos = $this->group->getPhotos($c);
            }
            
            
        }

        $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__("%1's Photos | eMarketTurkey", array('%1' => $this->group)));
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