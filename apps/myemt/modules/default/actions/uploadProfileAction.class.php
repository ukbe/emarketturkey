<?php

class uploadProfileAction extends EmtAction
{
    public function execute($request)
    {
        if ($this->getRequest()->getFileName('upload_file') == '')
        {
            $isValidationError = true;
            $error = "Please select an image file to upload as profile picture.";
        }
        else
        {
            $isValidationError = false;
        }

        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
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
                
                $this->sesuser->setProfilePictureId($this->fileobj->getId());

                $con->commit();
                $success = true;
            }
            catch (Exception $e)
            {
                $con->rollBack();
                $success = false;
            }
            
            if($success)
                $p = 'window.parent.OnUploadComplete(1, "", "'.$this->sesuser->getProfilePicture()->getUncroppedThumbUri().'");';
            else
                $p = 'window.parent.OnUploadComplete(0, "ERROR OCCURED", "'.$this->sesuser->getProfilePicture()->getUncroppedThumbUri().'");';
            return $this->renderText("<script>$p</script>");
        }
        elseif ($this->getRequest()->getMethod() == sfRequest::POST && $isValidationError)
        {
            return $this->renderText('<script>window.parent.OnUploadComplete(0, "'.$error.'", "'.$this->sesuser->getProfilePicture()->getUncroppedThumbUri().'");</script>');
        }
        else
        {
            return $this->renderText('<script>window.parent.OnUploadComplete(0, "'.$error.'", "'.$this->sesuser->getProfilePicture()->getUncroppedThumbUri().'");</script>');
        }
    }
}