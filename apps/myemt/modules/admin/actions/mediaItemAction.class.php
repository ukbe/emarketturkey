<?php

class mediaItemAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->mediaItem = MediaItemPeer::retrieveByPK($this->getRequestParameter('id'));

            if (!$this->mediaItem || md5($this->mediaItem->getFilename().$this->mediaItem->getId().session_id())!=$this->getRequestParameter('do'))
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Media Item: %1', array('%1' => $this->mediaItem->getFilename())));
        }
        else
        {
            $this->redirect404();
        }
        
        if ($this->getRequestParameter('act') == 'rem')
        {
            $this->mediaItem->delete();
            $this->redirect('admin/mediaItems');
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(MediaItemPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();
                
                if ($this->getRequestParameter('act') == 'rmk')
                {
                    $this->mediaItem->store($this->mediaItem->getPath());
                }
                elseif ($this->getRequestParameter('act') == 'rpl' && $this->getRequest()->getFileName('upload_file')!='')
                {
                    $this->mediaItem->store($this->getRequest()->getFilePath('upload_file'));
                    $this->getRequest()->moveFile('upload_file', $this->mediaItem->getPath(false));
                }

                $this->mediaItem->save();
                
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Media Item information has been saved successfully.', null, null, true);
                if ($this->getRequestParameter('act')!='rmk' && $this->getRequestParameter('act')!='rpl')
                    $this->redirect('admin/mediaItems');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing Media Item information. Please try again later.', null, null, false);
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
    
    public function validate()
    {   
        return !$this->getRequest()->hasErrors();
    }
}
