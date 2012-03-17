<?php

class logoAction extends EmtManageCompanyAction
{
    public function execute($request)
    {
        return $this->handleAction(false);
    }

    private function handleAction($isValidationError)
    {
        $this->logo = $this->company->getLogo();
        $this->uploadError =false;

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->getRequestParameter('process') == 'thumb')
            {
                $coords = $this->getRequestParameter('coords');
                $crop = $this->getRequestParameter('crop');
                $guid = $this->getRequestParameter('ref');
                $file = MediaItemPeer::retrieveItemsFor($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, null, $guid);
                $file = count($file) ? $file[0] : null;
                if (!$file) $this->redirect("@upload-company-logo?hash={$this->company->getHash()}");

                if ($this->logo)
                {
                    if ($this->logo->getGuid() != $guid && !$file->getIsTemp())
                    {
                        $file = MediaItemPeer::createMediaItem($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, MediaItemPeer::MI_TYP_LOGO, $file->getOriginalFilePath(), false, array('crop' => $crop, 'coords' => $coords));
                        $this->logo->delete();
                        ActionLogPeer::Log($this->company, ActionPeer::ACT_UPLOAD_LOGO, null, $file);
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
                        $file = MediaItemPeer::createMediaItem($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, MediaItemPeer::MI_TYP_LOGO, $file->getOriginalFilePath(), false, array('crop' => $crop, 'coords' => $coords));
                        ActionLogPeer::Log($this->company, ActionPeer::ACT_UPLOAD_LOGO, null, $file);
                    }
                }
                $this->logo = $file;
            }
            elseif ($this->getRequest()->getFileName('companylogo') == '')
            {
                if ($this->getRequestParameter('js') == 'true') return $this->renderText(json_encode(array('status' => 0, 'message' => $this->getContext()->getI18n()->__('Please select an image file to upload as company logo.'), 'uri' => '')));
                $this->getRequest()->setError('companylogo', 'Please select an image file to upload as company logo.');
            }
            else
            {
                $con = Propel::getConnection(MediaItemPeer::DATABASE_NAME);
                try
                {
                    $con->beginTransaction();

                    $this->logo = MediaItemPeer::createMediaItem($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, MediaItemPeer::MI_TYP_LOGO, $_FILES['companylogo'], true);
   
                    $con->commit();
                    
                    if ($this->getRequestParameter('js') == 'true') return $this->renderText(json_encode(array('status' => 1, 'message' => '', 'uri' => $this->logo->getOriginalFileUri())));
                }
                catch (Exception $e)
                {
                    $con->rollBack();
                    ErrorLogPeer::Log($this->company, PrivacyNodeTypePeer::PR_NTYP_COMPANY, "Error Occured During logo upload\nMsg:{$e->getMessage()}\nFile:{$e->getFile()} Line:{$e->getLine()}");
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
