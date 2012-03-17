<?php

class logoAction extends EmtGroupAction
{
    protected $actionID = ActionPeer::ACT_UPLOAD_LOGO;
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    public function handleAction($isValidationError)
    {
        if (!$this->goodToRun) $this->redirect404();
        
        $this->logo = $this->group->getLogo();
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
            {
                $con = Propel::getConnection(MediaItemPeer::DATABASE_NAME);
                try
                {
                    $con->beginTransaction();

                    //if ($this->logo)
                    //{
                        //$this->logo->delete();
                    //}
                
                    $filename = $this->getRequest()->getFileName('grouplogo');
                    $filename_parts = explode('.', $filename);
                    $fileextention = $filename_parts[count($filename_parts)-1];
                    $this->fileobj = new MediaItem();
                    $this->fileobj->setFilename($filename);
                    $this->fileobj->setFileExtention($fileextention);
                    $this->fileobj->setFileSize($this->getRequest()->getFileSize('grouplogo'));
                    $this->fileobj->setOwnerId($this->group->getId());
                    $this->fileobj->setOwnerTypeId(PrivacyNodeTypePeer::PR_NTYP_GROUP);
                    $this->fileobj->setItemTypeId(MediaItemPeer::MI_TYP_ALBUM_PHOTO);
                    $this->fileobj->save();
                    $this->fileobj->reload();
                    $this->fileobj->store($this->getRequest()->getFilePath('grouplogo'));
                    $this->getRequest()->moveFile('grouplogo', $this->fileobj->getPath(false));
   
                    $this->getUser()->setMessage('Group Logo Uploaded', 'Your new logo was uploaded successfully.', null, null, false);
                    
                    $this->group->setProfilePictureId($this->fileobj->getId());
                    
                    $con->commit();
                }
                catch (Exception $e)
                {
                    $con->rollBack();
                    $this->getUser()->setMessage('Error Occured!', 'Error occured while storing your logo. Please try again later.', null, null, false);
                    ErrorLogPeer::Log($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, $e->getMessage());
                }
            }
        }
        else
        {
        }
        
        $this->logo = $this->group->getLogo();
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
