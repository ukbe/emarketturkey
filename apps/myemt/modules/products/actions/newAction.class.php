<?php

class newAction extends EmtManageProductAction
{
    protected $enforceProduct = false;
    
    public function handleAction($isValidationError)
    {
        // Prepare variables from original Product
        
        if ($this->product instanceof Product)
        {
            // Handle relevant actions
            if ($this->getRequestParameter('act')=='rmp' && ($photo = $this->product->getPhotoById($this->getRequestParameter('pid'))))
            {
                $photo->delete();
                if ($this->refUrl) $this->redirect($this->refUrl);
            }
            
            $this->photos = $this->product->getPhotos();
            $this->category = $this->product->getProductCategory();
            $this->i18ns = $this->product->getExistingI18ns();
            $this->attrmatrix = $this->product->getAttributeMatrix();
            $this->payment_terms = unserialize($this->product->getPaymentTerms());

            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Product: %1', array('%1' => $this->product->__toString())));
        }
        else
        {
            $this->product = new Product();
            $this->photos = array();
            $this->category = null;
            $this->i18ns = array();
            $this->payment_terms = array();
            $this->attrmatrix = array('qualified' => array(), 'unqualified' => array());
        }
        
        
        // Manipulate variables from form post

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            if ($this->hasRequestParameter('pcategory_id') && is_numeric($this->getRequestParameter('pcategory_id')))
            {
                $this->category = ProductCategoryPeer::retrieveByPK($this->getRequestParameter('pcategory_id'));
            }
            
            $attr_vals = $this->getRequestParameter('attr_val');
            $attr_keys = $this->getRequestParameter('attr_key');
            $attr_keys = is_array($attr_keys) ? $attr_keys : array();
			$this->payment_terms = $this->getRequestParameter('payment_terms', array());

            $this->attrmatrix['qualified'] = array();
            if ($this->category)
            {
                foreach ($this->category->getAttributes() as $attrdef)
                {
                    $this->attrmatrix['qualified'][$attrdef->getId()] = $this->getRequestParameter("attr_{$attrdef->getId()}");
                }
            }
            
            $this->attrmatrix['unqualified'] = count($attr_keys) ? array_filter(array_combine($attr_keys, $attr_vals)) : array();
            
            if (!$isValidationError)
            {
                $con = Propel::getConnection(ProductPeer::DATABASE_NAME);
                
                try
                {
                    $con->beginTransaction();
    
                    $this->product->setCategoryId($this->category->getId());
                    $this->product->setCompanyId($this->company->getId());

                    $this->product->setPaymentTerms(serialize($this->payment_terms));
                    $this->product->setModelNo($this->getRequestParameter('product_model'));

					$this->product->setOrigin($this->getRequestParameter('product_origin'));
					$this->product->setKeyword($this->getRequestParameter('product_keyword'));

					$this->product->setMinOrderQuantity(myTools::fixInt($this->getRequestParameter('product_min_order')));
					$this->product->setQuantityUnit(myTools::fixInt($this->getRequestParameter('product_min_order_unit')));

					$this->product->setPriceCurrency($this->getRequestParameter('product_price_currency'));
					$this->product->setPriceStart(myTools::fixInt($this->getRequestParameter('product_price_start')));
					$this->product->setPriceEnd(myTools::fixInt($this->getRequestParameter('product_price_end')));
					$this->product->setPriceUnit(myTools::fixInt($this->getRequestParameter('product_price_unit')));

					$this->product->setCapacity(myTools::fixInt($this->getRequestParameter('product_capacity')));
					$this->product->setCapacityUnit(myTools::fixInt($this->getRequestParameter('product_capacity_unit')));
					$this->product->setCapacityPeriodId(myTools::fixInt($this->getRequestParameter('product_capacity_period')));

					// Set product group
					if ($this->getRequestParameter('product_group_id') == 'new'){
						$grp = new ProductGroup();
						$grp->setName($this->getRequestParameter('product_new_group'));
						$grp->setCompanyId($this->company->getId());
						$grp->setDefaultLang($this->getUser()->getCulture());
						$grp->save();
    					$this->product->setGroupId($grp->getId());
					}
					elseif ($group = $this->company->getProductGroupById($this->getRequestParameter('product_group_id'))){
						$this->product->setGroupId($group->getId());
					}
					else {
					   $this->product->setGroupId(null);
					}

					// Set product brand
					switch ($this->getRequestParameter('product_brand_owner')){
					case CompanyBrandPeer::BRND_HOLDED_BY_COMPANY : 
						switch ($this->getRequestParameter('product_brand_id')){
							case 'new' : 
								$brand = new CompanyBrand();
								$brand->setCompanyId($this->company->getId());
								$brand->setName($this->getRequestParameter('product_new_brand'));
								$brand->save();
								$this->product->setBrandId($brand->getId());
								$this->product->setBrandName(null);
								break;
							default :
 								if ($brand = $this->company->getBrandById($this->getRequestParameter('product_brand_id'))){
									$this->product->setBrandId($brand->getId());
								}
								else{
    								$this->product->setBrandId(null);
    								$this->product->setBrandName(null);
								}
								break;
						}
						break;
					case CompanyBrandPeer::BRND_HOLDED_BY_ELSE : 
						$this->product->setBrandId(null);
						$this->product->setBrandName($this->getRequestParameter('product_brand_name'));
						break;
					}
					
                    $isnew = $this->product->isNew();
                    
                    // Set online status
                    $this->product->setActive($this->getRequestParameter('product_active') == 'online' ? 1 : 0);
                    
                    // Check if Auto Activate Product is enabled
					if ($isnew)
					{
    					if (GlobalConfigPeer::getConfig(GlobalConfigPeer::GC_AUTO_ACTIVATE_PRODUCT) == true){
        					$this->product->setApprovalStatus(ProductPeer::PR_STAT_APPROVED);
    					}
    					else{
    						$this->product->setApprovalStatus(GlobalConfigPeer::getConfig(GlobalConfigPeer::GC_NEW_PRODUCT_STATUS));
    					}
					}

                    $pr = $this->getRequestParameter('product_lang');
                    $this->product->setDefaultLang($pr[0]);

                    $this->product->save();

                    $attrmatrix = $this->attrmatrix;

                    foreach ($attrmatrix['qualified'] as $id => $obj)
                    {
                        $attrmatrix['qualified'][$id] = $this->getRequestParameter("attr_$id");
                    }

                    $this->product->setAttributes($attrmatrix);
                    $this->product->save();

                    if (is_array($pr))
                    {
                        foreach($pr as $key => $lang)
                        {
                            if ($this->product->hasLsiIn($lang))
                            {
                                $sql = "UPDATE EMT_PRODUCT_I18N 
                            			SET id=:id, culture=:culture, name=:name, introduction=:introduction, packaging=:packaging, html_content=:html_content
                            			WHERE id=:id AND culture=:culture
                                ";
                            }
                            else
                            {
                                $sql = "INSERT INTO EMT_PRODUCT_I18N 
                                        (id, culture, name, introduction, packaging, html_content)
                                        VALUES
                                        (:id, :culture, :name, :introduction, :packaging, :html_content)
                                ";
                            }
                            
                            $stmt = $con->prepare($sql);
                            $p_intro = $this->getRequestParameter("product_introduction_$key");
                            $p_hmtl = "";
                            $stmt->bindValue(':id', $this->product->getId());
                            $stmt->bindValue(':culture', $lang);
                            $stmt->bindValue(':name', $this->getRequestParameter("product_name_$key"));
                            $stmt->bindParam(':introduction', $p_intro, PDO::PARAM_STR, strlen($p_intro));
                            $stmt->bindValue(':packaging', $this->getRequestParameter("packaging_$key"));
                            $stmt->bindParam(':html_content', $p_html, PDO::PARAM_STR, strlen($p_html));
                            $stmt->execute();
                        }
                    }
                    if (!$isnew && count($diff = array_diff($this->i18ns, $pr))) $this->product->removeI18n($diff);
                    
                    if ($isnew && $this->product->getApprovalStatus() == ProductPeer::PR_STAT_APPROVED)
                        ActionLogPeer::Log($this->company, ActionPeer::ACT_ADD_PRODUCT, null, $this->product);
                    elseif ($this->product->getApprovalStatus() == ProductPeer::PR_STAT_APPROVED)
                        ActionLogPeer::Log($this->company, ActionPeer::ACT_UPDATE_PRODUCT, null, $this->product);
                    
                    $filename = $this->getRequest()->getFileName('product_photo');

                    if ($filename){
                        $file = MediaItemPeer::createMediaItem($this->product->getId(), PrivacyNodeTypePeer::PR_NTYP_PRODUCT, MediaItemPeer::MI_TYP_PRODUCT_PICTURE, $_FILES['product_photo'], false);
                    }

                    $con->commit();
                    $this->redirect("@list-products?hash={$this->company->getHash()}");
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    ErrorLogPeer::Log($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, null, $e);
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
        $pr = $this->getRequestParameter('product_lang');
        $pr = is_array($pr)?$pr:array();

        sfLoader::loadHelpers('I18N');

        if ($this->getRequestParameter('product_brand_owner') == CompanyBrandPeer::BRND_HOLDED_BY_COMPANY) {
            if ($this->getRequestParameter('product_brand_id') !== 'new' && !myTools::fixInt($this->getRequestParameter('product_brand_id')))
                $this->getRequest()->setError('product_brand', __('Please select a brand from the list.'));
            elseif ($this->getRequestParameter('product_brand_id') == 'new' && $this->getRequestParameter('product_new_brand') == '')
                $this->getRequest()->setError('product_brand', __('Please enter the name of new product brand.'));
        }
        if ($this->getRequestParameter('product_brand_owner') == CompanyBrandPeer::BRND_HOLDED_BY_ELSE && $this->getRequestParameter('product_brand_name') == '')
            $this->getRequest()->setError('product_brand', __('Please enter the name of the product brand.'));
        if ($this->getRequestParameter('product_group_id') == 'new' && $this->getRequestParameter('product_new_group') == '')
            $this->getRequest()->setError('product_group_id', __('Please enter the name of new product group.'));
            
        foreach ($pr as $key => $lang)
        {
            $lang = trim($lang);
            if ($lang == '')
                $this->getRequest()->setError("product_lang_$key", __('Please select a language which you will provide product information in.'));
            if (trim($this->getRequestParameter("product_name_$key")) == '')
                $this->getRequest()->setError("product_name_$key", $lang ? __('Please enter a product name for %1 language', array('%1' => format_language($lang))) : __('Please enter a product name.'));
            if (mb_strlen($this->getRequestParameter("product_name_$key")) > 400)
                $this->getRequest()->setError("product_name_$key", $lang ? __('Product name for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 400)) : __('Product name must be maximum %1 characters long.', array('%1' => 400)));
            if ($this->getRequestParameter("product_introduction_$key") == '')
                $this->getRequest()->setError("product_introduction_$key", $lang ? __('Please enter a product introduction for %1 language.', array('%1' => format_language($lang))) : __('Please enter a product introduction.'));
            if (mb_strlen($this->getRequestParameter("product_introduction_$key")) > 1800)
                $this->getRequest()->setError("product_introduction_$key", $lang ? __('Product introduction for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 1800)) : __('Product introduction must be maximum %1 characters long.', array('%1' => 1800)));
            if (mb_strlen($this->getRequestParameter("packaging_$key")) > 200)
                $this->getRequest()->setError("packaging_$key", $lang ? __('Product packaging details for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 200)) : __('Product packaging details must be maximum %1 characters long.', array('%1' => 200)));
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}