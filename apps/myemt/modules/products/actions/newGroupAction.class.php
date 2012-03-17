<?php

class newGroupAction extends EmtManageCompanyAction
{
    public function handleAction($isValidationError)
    {
        // Prepare variables from original Product Group
        
        $this->group = $this->company->getProductGroupById($this->getRequestParameter('id'));
        
        if ($this->getRequestParameter('id') != '' && !$this->group)
        {
            $this->redirect404(); 
        }
        
        if ($this->group instanceof ProductGroup)
        {
            // Handle relevant actions
            if ($this->getRequestParameter('act')=='rm')
            {
                $group->delete();
            }
            
            $this->i18ns = $this->group->getExistingI18ns();
            
            $this->getResponse()->setTitle(sfContext::getInstance()->getI18N()->__('Edit Product Group: %1', array('%1' => $this->group->getNameByPriority())));
        }
        else
        {
            if ($this->company->countProductGroups() < GlobalConfigPeer::getConfig(GlobalConfigPeer::GC_NUM_PRODUCT_GROUPS))
            {
                $this->group = new ProductGroup();
                $this->i18ns = array();
            }
            else
            {
                $this->redirect("@list-product-groups?hash={$this->company->getHash()}");
            }
        }
        
        // Manipulate variables from form post

        if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
            

            if (!$isValidationError)
            {
                $con = Propel::getConnection(ProductGroupPeer::DATABASE_NAME);

                try
                {
                    $con->beginTransaction();
    
                    $isnew = $this->group->isNew();
                    
                    $pr = $this->getRequestParameter('group_lang');
                    $this->group->setCompanyId($this->company->getId());
                    $this->group->setDefaultLang($pr[0]);
                    $this->group->setName('tmp');
                    
                    $this->group->save();
                    
                    if (!in_array($this->getUser()->getCulture(), $pr)) $this->group->getCurrentProductGroupI18n()->delete();
                    

                    if (is_array($pr))
                    {
                        foreach($pr as $key => $lang)
                        {
                            $pi18n = $this->group->getCurrentProductGroupI18n($lang);
                            $pi18n->setName($this->getRequestParameter("group_name_$key"));
                            $pi18n->save();
                        }
                    }
                    
                    if (!$isnew && count($diff = array_diff($this->i18ns, $pr))) $this->group->removeI18n($diff);
                    
                    $con->commit();
                    $this->redirect("@list-product-groups?hash={$this->company->getHash()}");
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    ErrorLogPeer::Log($this->company->getId(), PrivacyNodeTypePeer::PR_NTYP_COMPANY, $e->getMessage(). ';' . $e->getFile() . ';' . $e->getLine());
                }
            }
        }
    }
    
    public function execute($request)
    {
         $this->handleAction(false);
    }
    
    public function validate()
    {
        $pr = $this->getRequestParameter('group_lang');
        $pr = is_array($pr)?$pr:array();

        foreach ($pr as $key => $lang)
        {
            if ($lang == '')
                $this->getRequest()->setError("group_lang_$key", sfContext::getInstance()->getI18N()->__('Please select a language which you will provide product group information in.'));
            if (mb_strlen($this->getRequestParameter("group_name_$key")) > 255)
                $this->getRequest()->setError("group_name_$key", sfContext::getInstance()->getI18N()->__('Product group name for %1 language must be maximum %2 characters long.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang), '%2' => 255)));
            if (mb_strlen(trim($this->getRequestParameter("group_name_$key"))) == 0)
                $this->getRequest()->setError("group_name_$key", sfContext::getInstance()->getI18N()->__('Enter a product group name for %1 language.', array('%1' => sfContext::getInstance()->getI18N()->getNativeName($lang))));
        }
        return !$this->getRequest()->hasErrors();
    }

    public function handleError()
    {
        $this->handleAction(true);
        return sfView::SUCCESS;
    }
}