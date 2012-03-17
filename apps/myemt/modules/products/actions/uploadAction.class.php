<?php

class uploadAction extends EmtManageProductAction
{
    private function handleAction($isValidationError)
    {
        if (!$this->product || md5($this->product->getName().$this->product->getId().session_id())!=$this->getRequestParameter('do'))
        {
            $this->redirect404();
        }

        $this->photos = $this->product->getPhotos();
                
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(MediaItemPeer::DATABASE_NAME);
            try
            {
                $con->beginTransaction();

                $filename = $this->getRequest()->getFileName('new_photo');
                if ($filename)
                {
                    $filename_parts = explode('.', $filename);
                    $fileextention = $filename_parts[count($filename_parts)-1];
                    $this->fileobj = new MediaItem();
                    $this->fileobj->setFilename($filename);
                    $this->fileobj->setFileExtention($fileextention);
                    $this->fileobj->setFileSize($this->getRequest()->getFileSize('new_photo'));
                    $this->fileobj->setOwnerId($this->product->getId());
                    $this->fileobj->setOwnerTypeId(PrivacyNodeTypePeer::PR_NTYP_PRODUCT);
                    $this->fileobj->setItemTypeId(MediaItemPeer::MI_TYP_PRODUCT_PICTURE);
                    $this->fileobj->save();
                    $this->fileobj->reload();
                    $this->fileobj->store($this->getRequest()->getFilePath('new_photo'));
                    $this->getRequest()->moveFile('new_photo', $this->fileobj->getPath(false));
                }
                $con->commit();
                $this->getUser()->setMessage('Photo Stored!', 'Product photo has been stored successfully.', null, null, true);
            }
            catch (Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new product photo. Please try again later.', null, null, true);
            }
        }
        else
        {
            $this->getUser()->setMessage('Error Occured!', 'Please select a image file in order to upload.', null, null, true);
        }
        
        $this->redirect("@edit-product?hash={$this->company->getHash()}&id={$this->product->getId()}&do=".md5($this->product->getName().$this->product->getId().session_id()));
    }
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    public function validate()
    {
        $this->getRequest()->setAttribute('errors', array());
        if (!$this->getRequest()->hasFile('new_photo')) $this->getRequest()->setError('new_photo', 'Please select a photo file to upload.');
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}
