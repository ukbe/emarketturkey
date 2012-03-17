<?php

/**
 * index action.
 *
 * @package b2b
 * @sub-package login
 */
class uploadAction extends EmtAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
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
                    $this->fileobj->setOwnerId($this->getUser()->getUser()->getId());
                    $this->fileobj->setOwnerTypeId(PrivacyNodeTypePeer::PR_NTYP_USER);
                    $this->fileobj->setItemTypeId(MediaItemPeer::MI_TYP_ALBUM_PHOTO);
                    $this->fileobj->save();
                    $this->fileobj->reload();
                    $this->fileobj->store($this->getRequest()->getFilePath('upload_file'));
                    $this->getRequest()->moveFile('upload_file', $this->fileobj->getPath(false));
                    
                    $this->getUser()->setMessage('Photo Uploaded', 'Your new photo was uploaded successfully.', null, null, false);
                    
                    if ($this->getRequestParameter('set_as_profile_image') == 'yes')
                    {
                        $this->user->setProfilePictureId($this->fileobj->getId());
                    }
    
                    if ($this->getRequestParameter('store_in_album', '0') !== 0)
                    {
                        if ($this->getRequestParameter('store_in_album', '0') === 'new' && $this->getRequestParameter('new_album') !== '')
                        {
                            $alb = $this->user->getFolderByName($this->getRequestParameter('new_album'));
                            if (!$alb)
                            {
                                $alb = $this->user->createAlbum($this->getRequestParameter('new_album'));
                            }
                        }
                        else
                        {
                            $alb = $this->user->getAlbum($this->getRequestParameter('store_in_album'));
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
                    $this->getUser()->setMessage('Error Occured!', 'Error occured while storing your photo. Please try again later.', null, null, false);
                }
            }
        }
        else
        {
        }
        $albums = $this->user->getAlbums();
        $this->albums = array();
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