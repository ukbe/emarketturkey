<?php

class photosAction extends EmtAction
{
    public function handleAction($isValidationError)
    {
        $this->user = $this->getUser()->getUser();
        $this->company = CompanyPeer::getCompanyFromUrl($this->getRequest()->getParameterHolder());
        
        if (!$this->company) $this->redirect404();
        
        if ($this->hasRequestParameter('id') && is_numeric($this->getRequestParameter('id')))
        {
            $this->product = $this->company->getProduct($this->getRequestParameter('id'));
            if (!$this->product || md5($this->product->getName().$this->product->getId().session_id())!=$this->getRequestParameter('do'))
            {
                $this->redirect404();
            }
            $this->photos = $this->product->getPhotos();
        }
        else
        {
            $this->product = new Product();
            $this->photos = array();
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $this->product->setName($this->getRequestParameter('product_name'));
                $this->product->setCompanyId($this->company->getId());
                $this->product->setPaymentTermId($this->getRequestParameter('payment_term_id'));
                $this->product->setCategoryId($this->getRequestParameter('pcategory_id'));
                $this->product->setModelNo($this->getRequestParameter('product_model'));
                
                $pr = $this->getRequestParameter('languages');
                
                foreach($pr as $lang)
                {
                    $pi18n = $this->product->getCurrentProductI18n($lang);
                    $pi18n->setDisplayName($this->getRequestParameter('displayname_'.$lang));
                    $pi18n->setIntroduction($this->getRequestParameter('product_introduction_'.$lang));
                    $pi18n->setPackaging($this->getRequestParameter('packaging_'.$lang));
                    $pi18n->setMinimumOrder('foo');
                    $pi18n->setHtmlContent('foo');
                    $pi18n->save();
                }
                $this->product->save();
                
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
                    
                    $folder = explode('/', $this->fileobj->getPath());
                    array_pop($folder);
                    $folder = implode('/', $folder);
                    if (!is_dir($folder)) mkdir($folder, 0777, true); 
    
                    $folder = explode('/', $this->fileobj->getThumbnailPath());
                    array_pop($folder);
                    $folder = implode('/', $folder);
                    if (!is_dir($folder)) mkdir($folder, 0777, true); 
                    
                    $large = new sfThumbnail(300, 250);
                    $large->loadFile($this->getRequest()->getFilePath('new_photo'));
                    $large->save($this->fileobj->getPath());
                    
                    $thumbnail = new sfThumbnail(140, 140);
                    $thumbnail->loadFile($this->getRequest()->getFilePath('new_photo'));
                    $thumbnail->save($this->fileobj->getThumbnailPath());
                }
                $con->commit();
                $this->getUser()->setMessage('Information Saved!', 'Product information has been saved successfully.', null, null, true);
                $this->redirect('products/list');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage('Error Occured!', 'Error occured while storing new product information. Please try again later.', null, null, false);
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
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