<?php

class logoAction extends EmtManageGroupAction
{
    protected $actionID = ActionPeer::ACT_UPLOAD_LOGO;
    
    public function execute($request)
    {
        $this->handleAction(false);
    }
    
    public function handleAction($isValidationError)
    {
        $this->logo = $this->group->getLogo();
        $this->uploadError =false;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('process') == 'thumb')
            {
                $coords = $this->getRequestParameter('coords');
                $crop = $this->getRequestParameter('crop');
                $guid = $this->getRequestParameter('ref');
                $file = MediaItemPeer::retrieveItemsFor($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, null, $guid);
                $file = count($file) ? $file[0] : null;
                if (!$file) $this->redirect("@upload-group-logo?hash={$this->group->getHash()}");

                if ($this->logo)
                {
                    if ($this->logo->getGuid() != $guid && !$file->getIsTemp())
                    {
                        $file = MediaItemPeer::createMediaItem($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, MediaItemPeer::MI_TYP_LOGO, $file->getOriginalFilePath(), false, array('crop' => $crop, 'coords' => $coords));
                        $this->logo->delete();
                        ActionLogPeer::Log($this->group, ActionPeer::ACT_UPLOAD_LOGO, null, $file);
                    }
                    else
                    {
                        $file->setCrop($crop);
                        $file->setOffsetCoords($coords);
                        $file->setIsTemp(false);
                        $file->save();
                        $file->sampleFiles();
                        if ($this->logo->getGuid() != $guid) $this->logo->delete();
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
                    }
                    else
                    {
                        $file = MediaItemPeer::createMediaItem($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, MediaItemPeer::MI_TYP_LOGO, $file->getOriginalFilePath(), false, array('crop' => $crop, 'coords' => $coords));
                        ActionLogPeer::Log($this->group, ActionPeer::ACT_UPLOAD_LOGO, null, $file);
                    }
                }
                $this->logo = $file;
            }
            elseif ($this->getRequest()->getFileName('grouplogo') == '')
            {
                if ($this->getRequestParameter('js') == 'true') return $this->renderText(json_encode(array('status' => 0, 'message' => $this->getContext()->getI18n()->__('Please select an image file to upload as group logo.'), 'uri' => '')));
                $this->getRequest()->setError('grouplogo', 'Please select an image file to upload as group logo.');
            }
            else
            {
                $con = Propel::getConnection(MediaItemPeer::DATABASE_NAME);
                try
                {
                    $con->beginTransaction();

                    $this->logo = MediaItemPeer::createMediaItem($this->group->getId(), PrivacyNodeTypePeer::PR_NTYP_GROUP, MediaItemPeer::MI_TYP_LOGO, $_FILES['grouplogo'], true);
   
                    $con->commit();
                    
                    if ($this->getRequestParameter('js') == 'true') return $this->renderText(json_encode(array('status' => 1, 'message' => '', 'uri' => $this->logo->getOriginalFileUri())));
                }
                catch (Exception $e)
                {
                    $con->rollBack();
                    ErrorLogPeer::Log($this->group, PrivacyNodeTypePeer::PR_NTYP_GROUP, "Error Occured During logo upload\nMsg:{$e->getMessage()}\nFile:{$e->getFile()} Line:{$e->getLine()}");
                    if ($this->getRequestParameter('js') == 'true') return $this->renderText(json_encode(array('status' => 0, 'message' => $this->getContext()->getI18n()->__('Error Occured'), 'uri' => $this->fileobj->getOriginalFileUri())));
                    else $this->uploadError = true;
                }
            }
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
