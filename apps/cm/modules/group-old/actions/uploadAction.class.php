<?php

class uploadAction extends EmtGroupAction
{
    protected $actionID = ActionPeer::ACT_UPLOAD_PHOTO;
      
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        if (!$this->goodToRun) 
        {
            $this->setTemplate('protectedContent');
            return sfView::SUCCESS;
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                $con = Propel::getConnection(ResumeLanguagePeer::DATABASE_NAME);
                try
                {
                    $con->beginTransaction();
                    $filename = $this->getRequest()->getFileName('upload_file');
                    $filename_parts = explode('.', $filename);
                    $fileextention = $filename_parts[count($filename_parts)-1];
                    $this->fileobj = new MediaItem();
                    $this->fileobj->setFilename($filename);
                    $this->fileobj->setFileExtention($fileextention);
                    $this->fileobj->setFileSize($this->getRequest()->getFileSize('upload_file'));
                    $this->fileobj->setOwnerId($this->group->getId());
                    $this->fileobj->setOwnerTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
                    if ($this->getRequestParameter('set_as_profile_image') == 'yes')
                    {
                        $this->fileobj->setItemTypeId(MediaItemPeer::MI_TYP_LOGO);
                    }
                    else
                    {
                        $this->fileobj->setItemTypeId(MediaItemPeer::MI_TYP_ALBUM_PHOTO);
                    }
                    $this->fileobj->save();
                    $this->fileobj->reload();
                    $this->fileobj->store($this->getRequest()->getFilePath('upload_file'));
                    $this->getRequest()->moveFile('upload_file', $this->fileobj->getPath(false));
                    
                    $this->getUser()->setMessage('Photo Uploaded', 'New group photo was uploaded successfully.', null, null, false);
                    
                    // filtering duplicate logging of just uploaded profile photos
                    if ($this->getRequestParameter('set_as_profile_image') != 'yes')
                    {
                        ActionLogPeer::Log($this->group, ActionPeer::ACT_UPLOAD_PHOTO, null, $this->fileobj);
                    }
                    
                    if ($this->getRequestParameter('store_in_album', '0') !== 0)
                    {
                        if ($this->getRequestParameter('store_in_album', '0') === 'new' && $this->getRequestParameter('new_album') !== '')
                        {
                            $alb = $this->group->getFolderByName($this->getRequestParameter('new_album'));
                            if (!$alb)
                            {
                                $alb = $this->group->createAlbum($this->getRequestParameter('new_album'));
                            }
                        }
                        else
                        {
                            $alb = $this->group->getAlbum($this->getRequestParameter('store_in_album'));
                        }
                        if ($alb)
                        {
                            $this->fileobj->setFolderId($alb->getId());
                            $this->fileobj->save();
                        }
                        else
                        {
                            $this->album_error = true;
                        }
                    }
                    $con->commit();
                }
                catch (Exception $e)
                {
                    $con->rollBack();
                    $this->getUser()->setMessage('Error Occured!', 'Error occured while storing group photo. Please try again later.', null, null, false);
                }
            }
        }
        else
        {
        }
        $albums = $this->group->getAlbums();
        $this->albums = array(0 => $this->getContext()->getI18N()->__('none'), 'new' => $this->getContext()->getI18N()->__('new album'));
        foreach ($albums as $album)
            $this->albums[$album->getId()] = $album->getName();        
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