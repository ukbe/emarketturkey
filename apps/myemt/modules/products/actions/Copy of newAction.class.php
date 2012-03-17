<?php

class newAction extends EmtManageCompanyAction
{
    protected $enforceProduct = false;
    
    public function handleAction($isValidationError)
    {
        $this->categorytree=array();
        $pointer = null;
        
        if ($this->product instanceof Product)
        {
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Product: %1', array('%1' => $this->product->getName())));
            
            if ($this->getRequestParameter('act')=='rmp' && $photo = $this->product->getPhotoByGuid($this->getRequestParameter('phid')))
            {
                $photo->delete();
            }
            
            $this->photos = $this->product->getPhotos();
            if ($this->hasRequestParameter('pcategory_id') && is_numeric($this->getRequestParameter('pcategory_id')))
            {
                $pointer = ProductCategoryPeer::retrieveByPK($this->getRequestParameter('pcategory_id'));
            }
            else
            {
                $pointer = $this->product->getProductCategory();
            }

            while ($pointer !== null)
            {
                $parent = $pointer->getParent();
                if ($parent) $cats = $parent->getSubCategories();
                else $cats = ProductCategoryPeer::getBaseCategories();
                
                $categories = array();
                foreach ($cats as $cat)
                    $categories[$cat->getId()] = $cat->getName();
                
                $this->categorytree[] = array($pointer->getId() => $categories);
                
                $pointer = $parent;
            }
        }
        else
        {
            $this->product = new Product();
            $this->photos = array();

            if ($this->hasRequestParameter('pcategory_id') && is_numeric($this->getRequestParameter('pcategory_id')))
            {
                $pointer = ProductCategoryPeer::retrieveByPK($this->getRequestParameter('pcategory_id'));
            }
            if ($pointer)
            {
                while ($pointer !== null)
                {
                    $parent = $pointer->getParent();
                    if ($parent) $cats = $parent->getSubCategories();
                    else $cats = ProductCategoryPeer::getBaseCategories();
                    
                    $categories = array();
                    foreach ($cats as $cat)
                        $categories[$cat->getId()] = $cat->getName();
                    
                    $this->categorytree[] = array($pointer->getId() => $categories);
                    
                    $pointer = $parent;
                }
            }
            else
            {
                $cats = ProductCategoryPeer::getBaseCategories();
                $categories = array();
                foreach ($cats as $cat)
                    $categories[$cat->getId()] = $cat->getName();
                
                $this->categorytree[] = array("" => $categories);
            }
        }
        
        if ($this->getRequest()->getMethod() == sfRequest::POST && !$isValidationError)
        {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME);
            
            try
            {
                $con->beginTransaction();

                $this->product->setName($this->getRequestParameter('product_name'));
                $this->product->setCompanyId($this->company->getId());
                $this->product->setPaymentTerms(serialize($this->getRequestParameter('payment_terms')));
                $this->product->setCategoryId($this->getRequestParameter('pcategory_id'));
                $this->product->setModelNo($this->getRequestParameter('product_model'));
                $isnew = $this->product->isNew();
                $this->product->save();
                
                $pr = $this->getRequestParameter('languages');
                
                if ($isnew)
                    ActionLogPeer::Log($this->company, ActionPeer::ACT_ADD_PRODUCT, null, $this->product);
                else
                    ActionLogPeer::Log($this->company, ActionPeer::ACT_UPDATE_PRODUCT, null, $this->product);
                
                if (is_array($pr))
                {
                    foreach($pr as $lang)
                    {
                        $pi18n = $this->product->getCurrentProductI18n($lang);
                        $pi18n->setDisplayName($this->getRequestParameter('displayname_'.$lang));
                        $pi18n->setIntroduction($this->getRequestParameter('product_introduction_'.$lang));
                        $pi18n->setPackaging($this->getRequestParameter('packaging_'.$lang));
                        $pi18n->setMinimumOrder('');
                        $pi18n->setHtmlContent('');
                        $pi18n->save();
                    }
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
                    $this->fileobj->store($this->getRequest()->getFilePath('new_photo'));
                    $this->getRequest()->moveFile('new_photo', $this->fileobj->getPath(false));
                }
                $con->commit();
                $this->getUser()->setMessage($this->getContext()->getI18N()->__('Information Saved!'), $this->getContext()->getI18N()->__('Product information has been saved successfully.'), null, null, true);
                $this->redirect('products/list');
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->getUser()->setMessage($this->getContext()->getI18N()->__('Error Occured!'), $this->getContext()->getI18N()->__('Error occured while storing new product information. Please try again later.'), null, null, false);
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function validate()
    {
        $pr = $this->getRequestParameter('languages');
        $pr = is_array($pr)?$pr:array();
        
        foreach ($pr as $lang)
        {
            if (mb_strlen($this->getRequestParameter('displayname_'.$lang)) > 400)
                $this->getRequest()->setError('displayname_'.$lang, sfContext::getInstance()->getI18N()->__('Product display name for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 400)));
            if (mb_strlen($this->getRequestParameter('product_introduction_'.$lang)) > 1800)
                $this->getRequest()->setError('product_introduction_'.$lang, sfContext::getInstance()->getI18N()->__('Product description for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 1800)));
            if (mb_strlen($this->getRequestParameter('packaging_'.$lang)) > 200)
                $this->getRequest()->setError('packaging_'.$lang, sfContext::getInstance()->getI18N()->__('Product packaging details for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 200)));
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}