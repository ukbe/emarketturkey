<?php

class platformAdAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->ad = PlatformAdPeer::retrieveByPK($this->getRequestParameter('id'));

            if (!$this->ad || md5($this->ad->getTitle().$this->ad->getId().session_id())!=$this->getRequestParameter('do'))
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Platform Ad: %1', array('%1' => $this->ad->getTitle())));
        }
        else
        {
            if ($this->getRequestParameter('act') == 'rem' ||
                $this->getRequestParameter('act') == 'tog')
            {
                $this->redirect404();
            }
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('New Platform Ad'));

            $this->ad = new PlatformAd();
        }
        
        if ($this->getRequestParameter('act') == 'rem')
        {
            $this->ad->delete();
            $this->redirect('admin/platformAds');
        }
        elseif ($this->getRequestParameter('act') == 'tog')
        {
            $this->ad->setStatus($this->add->getStatus() == PlatformAdPeer::PAD_STAT_ONLINE ? PlatformAdPeer::PAD_STAT_SUSPENDED : PlatformAdPeer::PAD_STAT_ONLINE);
            $this->ad->save();
            $this->setTemplate('toggleAd');
            return sfView::SUCCESS;
        }
        elseif ($this->getRequestParameter('act')=='rmf' && ($file = $this->ad->getFileByGuid($this->getRequestParameter('fid'))))
        {
            $file->delete();
            return sfView::SUCCESS;
        }
        
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection();
            
            try
            {
                $con->beginTransaction();

                $this->ad->setTitle($this->getRequestParameter('ad_title'));
                $this->ad->setMessage($this->getRequestParameter('ad_message'));
                $this->ad->setAdNamespaceId($this->getRequestParameter('ad_namespace_id'));
                $this->ad->setUrl($this->getRequestParameter('ad_url'));
                $this->ad->setLocal($this->getRequestParameter('ad_local'));
                $this->ad->setRelatedCompanyId($this->getRequestParameter('ad_related_company_id'));
                //$this->ad->setTypeId($this->getRequestParameter('ad_type_id'));
                $this->ad->setViewPercentage($this->getRequestParameter('ad_view_percentage'));
                $this->ad->setClickLimit($this->getRequestParameter('ad_click_limit'));
                $this->ad->setViewLimit($this->getRequestParameter('ad_view_limit'));
                $from = $this->getRequestParameter('ad_valid_from');
                $this->ad->setValidFrom(mktime(0, 0, 1, $from['month'], $from['day'], $from['year']));
                $until = $this->getRequestParameter('ad_valid_until');
                $this->ad->setValidUntil(mktime(0, 0, 1, $until['month'], $until['day'], $until['year']));
                $this->ad->setStatus($this->getRequestParameter('ad_status'));
                $this->ad->setTypeId($this->getRequestParameter('ad_type_id'));
                $this->ad->save();
                
                $filename = $this->getRequest()->getFileName('ad_file');
                if ($filename)
                {
                    $filename_parts = explode('.', $filename);
                    $fileextention = $filename_parts[count($filename_parts)-1];
                    $this->fileobj = new MediaItem();
                    $this->fileobj->setFilename($filename);
                    $this->fileobj->setFileExtention($fileextention);
                    $this->fileobj->setFileSize($this->getRequest()->getFileSize('ad_file'));
                    $this->fileobj->setOwnerId($this->ad->getId());
                    $this->fileobj->setOwnerTypeId(PrivacyNodeTypePeer::PR_NTYP_ADVERTISEMENT);
                    $this->fileobj->setItemTypeId(MediaItemPeer::MI_TYP_PLATFORM_AD_FILE);
                    $this->fileobj->save();
                    $this->fileobj->reload();
                    $this->fileobj->store($this->getRequest()->getFilePath('ad_file'));
                    $this->getRequest()->moveFile('ad_file', $this->fileobj->getPath(false));
                }
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Platform advertisement has been saved successfully.', null, null, true);
                $this->redirect('admin/platformAds');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new Platform Advertisement. Please try again later.'.$e->getMessage(), null, null, false);
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
        $mimetypes = array(PlatformAdPeer::PAD_TYP_FLASH => array('application/x-shockwave-flash'),
                           PlatformAdPeer::PAD_TYP_IMAGE => array('image/jpeg', 'image/png', 'image/gif', 'image/tiff'));
        if ($this->getRequest()->hasFile('ad_file'))
        {
            if (!array_key_exists($this->getRequestParameter('ad_type_id'), $mimetypes))
                $this->getRequest()->setError('ad_type_id', 'Please select advertisement type.');
            elseif ($this->getRequestParameter('ad_type_id') != '' && array_search(mime_content_type($this->getRequest()->getFilePath('ad_file')), $mimetypes[$this->getRequestParameter('ad_type_id')])===false)
                $this->getRequest()->setError('ad_file', 'Please select a file which matches the type you have selected.');
        }
        return !$this->getRequest()->hasErrors();
    }
}
