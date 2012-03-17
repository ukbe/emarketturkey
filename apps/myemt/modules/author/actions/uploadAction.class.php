<?php

class uploadAction extends EmtAction
{
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    private function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        $this->author = $this->user->getAuthor();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            if (!$this->getUser()->hasCredential('editor'))
            {
                $this->publication = $this->author->getPublication($this->getRequestParameter('id'));
            }
            else
            {
                $this->publication = PublicationPeer::retrieveByPK($this->getRequestParameter('id'));
            }
            if (!$this->publication || md5($this->publication->getName().$this->publication->getId().session_id())!=$this->getRequestParameter('do'))
            {
                $this->redirect404();
            }
            $this->photos = $this->publication->getPhotos();
        }
        else
        {
            $this->publication = new Publication();
            $this->photos = array();
        }
                
        if ($this->publication->getTypeId()==PublicationPeer::PUB_TYP_ARTICLE)
        {
            $prefs[0] = 'Article photo has been stored successfully.';
            $prefs[1] = 'Error occured while storing article photo. Please try again later.';
            $prefs[2] = 'author/article?id='.$this->publication->getId()."&do=".md5($this->publication->getName().$this->publication->getId().session_id());
        }
        elseif ($this->publication->getTypeId()==PublicationPeer::PUB_TYP_NEWS)
        {
            $prefs[0] = 'News photo has been stored successfully.';
            $prefs[1] = 'Error occured while storing news photo. Please try again later.';
            $prefs[2] = 'author/news?id='.$this->publication->getId()."&do=".md5($this->publication->getName().$this->publication->getId().session_id());
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if (!$isValidationError)
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
                        $this->fileobj->setOwnerId($this->publication->getId());
                        $this->fileobj->setOwnerTypeId(PrivacyNodeTypePeer::PR_NTYP_PUBLICATION);
                        $this->fileobj->setItemTypeId(MediaItemPeer::MI_TYP_PUBLICATION_PHOTO);
                        $this->fileobj->save();
                        $this->fileobj->reload();
                        $this->fileobj->store($this->getRequest()->getFilePath('new_photo'));
                        $this->getRequest()->moveFile('new_photo', $this->fileobj->getPath(false));
                    }
                    $con->commit();
                    $this->getUser()->setMessage('Photo Stored!', $prefs[0], null, null, true);
                }
                catch (Exception $e)
                {
                    $con->rollBack();
                    $this->getUser()->setMessage('Error Occured!', $prefs[1], null, null, false);
                }
            }
        }
        else
        {
        }

        $this->redirect($prefs[2]);
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
