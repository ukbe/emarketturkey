<?php

class postAction extends EmtManageLeadAction
{
    protected $enforceLead = false;
    
    public function handleAction($isValidationError)
    {
        // Prepare variables from original Product
        
        if ($this->lead instanceof B2bLead)
        {
            // Handle relevant actions
            if ($this->getRequestParameter('act')=='rmp' && $photo = $this->lead->getPhotoById($this->getRequestParameter('pid')))
            {
                $photo->delete();
                if ($this->refUrl) $this->redirect($this->refUrl);
            }
            
            $this->photos = $this->lead->getPhotos();
            $this->category = $this->lead->getProductCategory();
            $this->i18ns = $this->lead->getExistingI18ns();
            $this->payment_terms = unserialize($this->lead->getPaymentTerms());

            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Lead: %1', array('%1' => $this->lead->getNameByPriority())));
        }
        else
        {
            $this->lead = new B2bLead();
            $this->lead->setTypeId($this->getRequestParameter('type_id'));
            $this->photos = array();
            $this->category = null;
            $this->i18ns = array();
            $this->payment_terms = array();
        }

        // Manipulate variables from form post

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->hasRequestParameter('category_id') && is_numeric($this->getRequestParameter('category_id')))
            {
                $this->category = ProductCategoryPeer::retrieveByPK($this->getRequestParameter('category_id'));
            }
            
            $this->payment_terms = $this->getRequestParameter('payment_terms', array());

            if (!$isValidationError)
            {
                $con = Propel::getConnection(B2bLeadPeer::DATABASE_NAME);
                
                try
                {
                    $con->beginTransaction();
    
                    $this->lead->setCategoryId($this->category->getId());
                    $this->lead->setCompanyId($this->company->getId());
                    $this->lead->setPaymentTerms(serialize($this->payment_terms));
                    $this->lead->setTypeId($this->getRequestParameter('lead_type_id'));
                    $this->lead->setExpiresAt($this->getRequestParameter('expires_at'));

                    $isnew = $this->lead->isNew();
                    $pr = $this->getRequestParameter('lead_lang');
                    $this->lead->setDefaultLang($pr[0]);
                    
                    $this->lead->save();


                    if (is_array($pr))
                    {
                        foreach($pr as $key => $lang)
                        {
                            $pi18n = $this->lead->getCurrentB2bLeadI18n($lang);
                            $pi18n->setName($this->getRequestParameter("product_name_$key"));
                            $pi18n->setDescription($this->getRequestParameter("product_description_$key"));
                            $pi18n->save();
                        }
                    }
                    if (!$this->lead->isNew() && count($diff = array_diff($this->i18ns, $pr))) $this->lead->removeI18n($diff);

                    $this->lead->save();
                    
                    $filename = $this->getRequest()->getFileName('lead_file');

                    if ($filename){
                        $file = MediaItemPeer::createMediaItem($this->lead->getId(), PrivacyNodeTypePeer::PR_NTYP_B2B_LEAD, MediaItemPeer::MI_TYP_PRODUCT_PICTURE, $_FILES['lead_file'], false);
                    }

                    $con->commit();
                    $this->redirect("@list-leads?hash={$this->company->getHash()}");
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    ErrorLogPeer::Log($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, $e->getMessage(). ';' . $e->getFile() . ';' . $e->getLine());
                }
            }
        }

        // Init variables with default values
        $this->categorytree = array();

        // Setup category hierarchy
        if ($this->category) {
            $cat_point = $this->category;
            while ($cat_point !== null)
            {
                $parent = $cat_point->getParent();
                if ($parent) $cats = $parent->getSubCategories(true);
                else $cats = ProductCategoryPeer::getBaseCategories(null, true);
                
                $this->categorytree[] = array($cat_point->getId() => $cats);
                
                $cat_point = $parent;
            }
        }
        else {
            $this->categorytree[] = array("" => ProductCategoryPeer::getBaseCategories(null, true));
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function validate()
    {
        $pr = $this->getRequestParameter('lead_lang');
        $pr = is_array($pr)?$pr:array();
        
        sfLoader::loadHelpers('I18N');
        
        foreach ($pr as $key => $lang)
        {
            $lang = trim($lang);
            if ($lang == '')
                $this->getRequest()->setError("lead_lang_$key", __('Please select a language which you will provide product information in.'));
            if (trim($this->getRequestParameter("product_name_$key")) == '')
                $this->getRequest()->setError("product_name_$key", $lang ? __('Please enter the product name for %1 language.', array('%1' => format_language($lang))) : __('Please enter the product name.'));
            if (mb_strlen($this->getRequestParameter("product_name_$key")) > 400)
                $this->getRequest()->setError("product_name_$key", $lang ? __('Product name for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 400)) : __('Product name must be maximum %1 characters long.', array('%1' => 400)));
            if (mb_strlen($this->getRequestParameter("product_description_$key")) > 1800)
                $this->getRequest()->setError("product_description_$key", $lang ? __('Product description for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 1800)) : __('Product description must be maximum %1 characters long.', array('%1' => 1800)));
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}