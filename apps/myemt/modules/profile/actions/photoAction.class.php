<?php

class photoAction extends EmtManageAction
{
    public function execute($request)
    {
        $this->photo = $this->sesuser->getProfilePicture();
        $this->uploadError =false;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('process') == 'thumb')
            {
                $coords = $this->getRequestParameter('coords');
                $crop = $this->getRequestParameter('crop');
                $guid = $this->getRequestParameter('ref');

                $files = MediaItemPeer::retrieveItemsFor($this->sesuser->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, null, $guid);
                $file = count($files) ? $files[0] : null;
                if (!$file) $this->redirect("default/setupProfile");

                if ($this->photo)
                {
                    if ($this->photo->getGuid() != $guid && !$file->getIsTemp())
                    {
                        $file = MediaItemPeer::createMediaItem($this->sesuser->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, MediaItemPeer::MI_TYP_ALBUM_PHOTO, $file->getOriginalFilePath(), false, array('crop' => $crop, 'coords' => $coords));
                        $this->photo->delete();
                    }
                    else
                    {
                        $file->setCrop($crop);
                        $file->setOffsetCoords($coords);
                        $file->setIsTemp(false);
                        $file->sampleFiles();
                        $file->save();
                        if ($this->photo->getGuid() != $guid) $this->photo->delete();
                        $this->sesuser->setProfilePictureId($file->getId());
                    }
                }
                else
                {
                    if ($file->getIsTemp() == true)
                    {
                        $file->setCrop($crop);
                        $file->setOffsetCoords($coords);
                        $file->setIsTemp(false);
                        $file->save();
                        $file->sampleFiles();
                        $this->sesuser->setProfilePictureId($file->getId());
                    }
                    else
                    {
                        $file = MediaItemPeer::createMediaItem($this->sesuser->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, MediaItemPeer::MI_TYP_ALBUM_PHOTO, $file->getOriginalFilePath(), false, array('crop' => $crop, 'coords' => $coords));
                    }
                }
                $this->photo = $file;
            }
            elseif ($this->getRequest()->getFileName('profilephoto') == '')
            {
                if ($this->getRequestParameter('js') == 'true') return $this->renderText(json_encode(array('status' => 0, 'message' => $this->getContext()->getI18N()->__('Please select an image file to upload as profile photo.'), 'uri' => '')));
                $this->getRequest()->setError('profilephoto', 'Please select an image file to upload as profile photo.');
            }
            else
            {
                $con = Propel::getConnection(MediaItemPeer::DATABASE_NAME);
                try
                {
                    $con->beginTransaction();

                    $this->photo = MediaItemPeer::createMediaItem($this->sesuser->getId(), PrivacyNodeTypePeer::PR_NTYP_USER, MediaItemPeer::MI_TYP_ALBUM_PHOTO, $_FILES['profilephoto'], true);
   
                    $con->commit();
                    
                    if ($this->getRequestParameter('js') == 'true') return $this->renderText(json_encode(array('status' => 1, 'message' => '', 'uri' => $this->photo->getOriginalFileUri())));
                }
                catch (Exception $e)
                {
                    $con->rollBack();
                    ErrorLogPeer::Log($this->sesuser, PrivacyNodeTypePeer::PR_NTYP_USER, "Error occured during profile photo upload", $e);
                    if ($this->getRequestParameter('js') == 'true') return $this->renderText(json_encode(array('status' => 0, 'message' => $this->getContext()->getI18N()->__('Error Occured'), 'uri' => $this->fileobj->getOriginalFileUri())));
                    else $this->uploadError = true;
                }
            }
        }

        $this->redirect('default/setupProfile');
    }
}