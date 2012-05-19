<?php

class PublicationCategoryPeer extends BasePublicationCategoryPeer
{
    CONST PCAT_FEATURED         = 1;
    
    CONST KNOWLEDGEBASE_CATEGORY_ID = 20;
    
    public static function getBaseCategories($cr=null, $for_select = false, $parent_id = null)
    {
        if ($cr)
        {
            $c = clone $cr;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(PublicationCategoryPeer::PARENT_ID, isset($parent_id) ? $parent_id : 0);
        $c->addAscendingOrderByColumn(myTools::NLSFunc(PublicationCategoryI18nPeer::NAME, 'SORT'));
        
        $cats  = PublicationCategoryPeer::doSelectWithI18n($c);
        
        if ($for_select)
        {
            $catys = array();
            foreach ($cats as $cat){
                $catys[$cat->getId()] = $cat->getName();
            }
            return $catys;
        }
        
        return $cats; 
    }
    
    public static function retrieveByStrippedCategory($category)
    {
        $c = new Criteria();
        $c->add(PublicationCategoryI18nPeer::STRIPPED_CATEGORY, $category);
        $cats = self::doSelectWithI18n($c);
        if (is_array($cats) && count($cats))
        {
            return $cats[0];
        }
        else
        {
            return null;
        }
    }
    
    public static function getPager($page, $items_per_page = 20, $c1_or_sql = null)
    {
        if ($c1_or_sql instanceof Criteria || is_null($c1_or_sql))
        {
            $c = ($c1_or_sql ? clone $c1_or_sql : new Criteria());
            $pager = new sfPropelPager('PublicationCategory', $items_per_page);
            $pager->setPage($page);
            $pager->setCriteria($c);
            $pager->init();
        }
        elseif ($c1_or_sql)
        {
            $pager = new EmtPager('PublicationCategory', $items_per_page);
            $pager->setPage($page);
            $pager->setSql($c1_or_sql);
            $pager->init();
        }
        return $pager;
    }

    public static function getInstance($params, $owner = null, $new = false)
    {
        if ($new)
        {
            $obj = new PublicationCategory();
        }
        else
        {
            $c = new Criteria();
            $c->add(PublicationCategoryPeer::ID, $params->get('id'));
            $obj = self::doSelectOne($c);
        }
        return $obj;
    }

    public static function validate($params, $author = null, $request)
    {
        sfLoader::loadHelpers('I18N');
        
        $parent = PublicationCategoryPeer::retrieveByPK($params->get('pubc_parent_id'));

        if ($params->get('pubc_parent_id') && !$parent)
            $request->setError("pubc_parent_id", __('Parent category does not exist.'));

        $pr = $params->get('pubc_lang');

        foreach ($pr as $key => $lang)
        {
            $lang = trim($lang);
            if ($lang == '')
                $request->setError("pubc_lang_$key", __('Please select a language which you will provide publication category information in.'));
            if (trim($request->getParameter("pubc_name_$key"))=='')
                $request->setError("pubc_name_$key", $lang ? __('Please enter a name for %1 language.', array('%1' => format_language($lang))) : __('Please enter a display name.'));
        }
                  
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null, $request)
    {
        if ($object instanceof PublicationCategory)
        {
            $con = Propel::getConnection();
    
            try
            {
                $i18ns = $object->getExistingI18ns();

                $con->beginTransaction();
                
                $object->setActive($params->get('pubc_active'));
                
                $pr = $params->get('pubc_lang');
                $object->setParentId($params->get('pubc_parent_id'));
                $object->setDefaultLang($pr[0]);
                $object->save();
                
                if (is_array($pr))
                {
                    foreach($pr as $key => $lang)
                    {
                        if ($object->hasLsiIn($lang))
                        {
                            $sql = "UPDATE EMT_PUBLICATION_CATEGORY_I18N 
                                    SET id=:id, culture=:culture, name=:name, stripped_category=:stripped_category
                                    WHERE id=:id AND culture=:culture
                            ";
                        }
                        else
                        {
                            $sql = "INSERT INTO EMT_PUBLICATION_CATEGORY_I18N 
                                    (id, culture, name, stripped_category)
                                    VALUES
                                    (:id, :culture, :name, :stripped_category)
                            ";
                        }
                        
                        $stmt = $con->prepare($sql);
                        $stmt->bindValue(':id', $object->getId());
                        $stmt->bindValue(':culture', $lang);
                        $stmt->bindValue(':name', $params->get("pubc_name_$key"));
                        $stmt->bindValue(':stripped_category', myTools::stripText($params->get("pubc_name_$key")));
                        $stmt->execute();
                    }
                }
                if (!$object->isNew() && count($diff = array_diff($i18ns, $pr))) $object->removeI18n($diff);
                            
                // Check if uploaded a new file
                $filename = $request->getFileName('pubc_file');
                if ($filename)
                    MediaItemPeer::createMediaItem($object->getId(), PrivacyNodeTypePeer::PR_NTYP_PUBLICATION_CATEGORY, MediaItemPeer::MI_TYP_PUBLICATION_CATEGORY_PHOTO, $_FILES['pubc_file'], false);

                $con->commit();
                
                $object->reload();

                return $object;
            }
            catch(Exception $e)
            {
                $con->rollBack();
                ErrorLogPeer::Log($object->getId() ? $object->getId() : 0, $object->getObjectTypeId(), "Error occured while saving Publication Category.\nPage:\nMessage:{$e->getMessage()}". $request->getUri());
                return $object;
            }
        }
        return null;
    }

    public static function getOrderedNames($for_select = false)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(PublicationCategoryI18nPeer::NAME);
        
        if ($for_select)
        {
            $cats = self::doSelectWithI18n($c);
            $catys = array();
            foreach ($cats as $cat){
                $catys[$cat->getId()] = $cat->getName();
            }
            return $catys;
        }
        
        return self::doSelectWithI18n($c);
    }

}
