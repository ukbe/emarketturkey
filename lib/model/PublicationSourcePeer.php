<?php

class PublicationSourcePeer extends BasePublicationSourcePeer
{
    CONST PSRC_FEATURED         = 1;
    
    public static function retrieveByStrippedName($name, $ignore_culture = false)
    {
        $c = new Criteria();
        $c->add(PublicationSourceI18nPeer::STRIPPED_DISPLAY_NAME, $name);
        if ($ignore_culture)
        {
            $pubs = PublicationSourceI18nPeer::doSelect($c);
        }
        else
        {
            $pubs = self::doSelectWithI18n($c);
        }
        if (is_array($pubs) && count($pubs))
        {
            return $ignore_culture ? $pubs[0]->getPublicationSource() : $pubs[0];
        }
        else
        {
            return null;
        }
    }
    
    public static function getPager($page, $items_per_page = 20, $c1 = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }

        $pager = new sfPropelPager('PublicationSource', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }

    public static function getOrderedNames($for_select = false)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(PublicationSourceI18nPeer::DISPLAY_NAME);
        
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

    public static function getInstance($params, $owner = null, $new = false)
    {
        if ($new)
        {
            $obj = new PublicationSource();
        }
        else
        {
            $c = new Criteria();
            $c->add(PublicationSourcePeer::ID, $params->get('id'));
            $obj = self::doSelectOne($c);
        }
        return $obj;
    }

    public static function validate($params, $author = null, $request)
    {
        sfLoader::loadHelpers('I18N');
        
        if (!(3 < mb_strlen($params->get("pubs_name")) && 
                  mb_strlen($params->get("pubs_name")) < 256)) $request->setError("pubs_name", 'Please enter a publication source name.');
        
        $pr = $params->get('pubs_lang');

        foreach ($pr as $key => $lang)
        {
            $lang = trim($lang);
            if ($lang == '')
                $request->setError("pubs_lang_$key", __('Please select a language which you will provide publication source information in.'));
            if (trim($request->getParameter("pubs_display_name_$key"))=='')
                $request->setError("pubs_display_name_$key", $lang ? __('Please enter a display name for %1 language.', array('%1' => format_language($lang))) : __('Please enter a display name.'));
            if (mb_strlen($request->getParameter("pubs_display_name_$key")) > 255)
                $request->setError("pubs_display_name_$key", $lang ? __('Publication Source display name for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 255)) : __('Publication Source display name must be maximum %1 characters long.', array('%1' => 255)));
            if (mb_strlen($request->getParameter("pubs_short_desc$key")) > 100)
                $request->setError("pubs_short_desc_$key", $lang ? __('Publication Source short description for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 100)) : __('Publication Source short description must be maximum %1 characters long.', array('%1' => 100)));
            if (mb_strlen($request->getParameter("pubs_description_$key")) > 512)
                $request->setError("pubs_description_$key", $lang ? __('Publication Source description for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 512)) : __('Publication Source description must be maximum %1 characters long.', array('%1' => 512)));
        }
                  
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null, $request)
    {
        if ($object instanceof PublicationSource)
        {
            $con = Propel::getConnection();
    
            try
            {
                $i18ns = $object->getExistingI18ns();

                $con->beginTransaction();
                
                $object->setName($params->get('pubs_name'));
                $object->setActive($params->get('pubs_active'));
                
                $pr = $params->get('pubs_lang');
                $object->setDefaultLang($pr[0]);
                $object->save();
                
                if (is_array($pr))
                {
                    foreach($pr as $key => $lang)
                    {
                        if ($object->hasLsiIn($lang))
                        {
                            $sql = "UPDATE EMT_PUBLICATION_SOURCE_I18N 
                                    SET id=:id, culture=:culture, display_name=:display_name, stripped_display_name=:stripped_display_name, short_description=:short_description, description=:description
                                    WHERE id=".$object->getId()." AND culture=:culture
                            ";
                        }
                        else
                        {
                            $sql = "INSERT INTO EMT_PUBLICATION_SOURCE_I18N 
                                    (id, culture, display_name, stripped_display_name, short_description, description)
                                    VALUES
                                    (:id, :culture, :display_name, :stripped_display_name, :short_description, :description)
                            ";
                        }
                        
                        $stmt = $con->prepare($sql);
                        $stmt->bindValue(':id', $object->getId());
                        $stmt->bindValue(':culture', $lang);
                        $stmt->bindValue(':display_name', $params->get("pubs_display_name_$key"));
                        $stmt->bindValue(':stripped_display_name', myTools::url_slug($params->get("pubs_display_name_$key")));
                        $stmt->bindValue(':short_description', $params->get("pubs_short_desc_$key"));
                        $stmt->bindValue(':description', $params->get("pubs_description_$key"));
                        $stmt->execute();
                    }
                }
                if (!$object->isNew() && count($diff = array_diff($i18ns, $pr))) $object->removeI18n($diff);
                            
                // Check if uploaded a new file
                $filename = $request->getFileName('pubs_file');
                if ($filename)
                    MediaItemPeer::createMediaItem($object->getId(), PrivacyNodeTypePeer::PR_NTYP_PUBLICATION_SOURCE, MediaItemPeer::MI_TYP_PUBLICATION_SOURCE_PHOTO, $_FILES['pubs_file'], false);

                $con->commit();
                
                $object->reload();
                return $object;
            }
            catch(Exception $e)
            {
                $con->rollBack();

                ErrorLogPeer::Log($object->getId() ? $object->getId() : 0, $object->getObjectTypeId(), "Error occured while saving Publication Source.\nPage:\nMessage:{$e->getMessage()}". $request->getUri());

                return $object;
            }
        }
        return null;
    }
}
