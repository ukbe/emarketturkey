<?php

class AuthorPeer extends BaseAuthorPeer
{
    CONST AUTH_FEATURED_COLUMN  = 1;
    
    public static function retrieveByStrippedName($name)
    {
        $c = new Criteria();
        $c->add(AuthorI18nPeer::STRIPPED_DISPLAY_NAME, $name);
        $auths = self::doSelectWithI18n($c);
        return (is_array($auths) && count($auths)) ? $auths[0] : null;
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

        $pager = new sfPropelPager('Author', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }

    public static function getOrderedNames($for_select = false)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(myTools::NLSFunc(AuthorI18nPeer::DISPLAY_NAME, 'SORT'));

        if ($for_select)
        {
            $cats = self::doSelectWithI18n($c);
            $catys = array();
            foreach ($cats as $cat){
                $catys[$cat->getId()] = $cat->getDisplayName();
            }
            return $catys;
        }
        
        return self::doSelectWithI18n($c);
    }

    public static function getInstance($params, $owner = null, $new = false)
    {
        if ($new)
        {
            $obj = new Author();
            if ($owner instanceof User){
                $obj->setUserId($owner->getId());
            }
        }
        else
        {
            $c = new Criteria();
            $c->add(AuthorPeer::ID, $params->get('id'));
            if ($owner) $c->add(AuthorPeer::USER_ID, $owner->getId());
            $obj = self::doSelectOne($c);
        }
        return $obj;
    }

    public static function validate($params, $author = null, $request)
    {
        $post_user = myTools::unplug(count($hashes = $params->get('auth_user_hash')) ? $hashes[0] : null);

        sfLoader::loadHelpers('I18N');
        
        $updating_account = AuthorPeer::retrieveByPK($params->get('id'));

        if ($post_user && $post_user->getAuthor() && (!$updating_account || $post_user->getAuthor()->getId() != $updating_account->getId()))
            $request->setError("auth_account_hash", 'Selected user already has an author account.');
        
        if (!(3 < strlen($params->get("auth_name")) && 
                  strlen($params->get("auth_name")) < 51)) $request->setError("auth_name", 'Please enter an author name.');
        
        if (!(3 < strlen($params->get("auth_lastname")) && 
                  strlen($params->get("auth_lastname")) < 51)) $request->setError("auth_lastname", 'Please enter an author lastname.');

        if (strlen($params->get("auth_salutation")) > 20) $request->setError("auth_salutation", __('Author salutation must be maximum %1 characters long.', array('%1' => 60)));
        
        $pr = $params->get('auth_lang');

        foreach ($pr as $key => $lang)
        {
            $lang = trim($lang);
            if ($lang == '')
                $request->setError("auth_lang_$key", __('Please select a language which you will provide author information in.'));
            if (trim($request->getParameter("auth_display_name_$key"))=='')
                $request->setError("auth_display_name_$key", $lang ? __('Please enter a display name for %1 language.', array('%1' => format_language($lang))) : __('Please enter a display name.'));
            if (mb_strlen($request->getParameter("auth_display_name_$key")) > 255)
                $request->setError("auth_display_name_$key", $lang ? __('Author display name for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 255)) : __('Author display name must be maximum %1 characters long.', array('%1' => 255)));
            if (mb_strlen($request->getParameter("auth_title_$key")) > 100)
                $request->setError("auth_title_$key", $lang ? __('Author title for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 100)) : __('Author title must be maximum %1 characters long.', array('%1' => 100)));
            if ($request->getParameter("auth_introduction_$key")=='')
                $request->setError("auth_introduction_$key", $lang ? __('Please enter an author introduction for %1 language.', array('%1' => format_language($lang))) : __('Please enter author introduction.'));
            if (mb_strlen($request->getParameter("auth_introduction_$key")) > 512)
                $request->setError("auth_introduction_$key", $lang ? __('Author introduction for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 512)) : __('Author introduction must be maximum %1 characters long.', array('%1' => 512)));
        }
                  
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null, $request)
    {
        if ($object instanceof Author)
        {
            $con = Propel::getConnection();
    
            try
            {
                $post_user = myTools::unplug(count($hashes = $params->get('auth_user_hash')) ? $hashes[0] : null);
                
                $i18ns = $object->getExistingI18ns();

                $con->beginTransaction();
                
                $object->setName($params->get('auth_name'));
                $object->setLastname($params->get('auth_lastname'));
                $object->setUserId($post_user ? $post_user->getId() : null);
                $object->setSalutation($params->get('auth_salutation'));
                $object->setActive($params->get('auth_active'));
                $object->setIsColumnist($params->get('auth_is_columnist'));
                
                $pr = $params->get('auth_lang');
                $object->setDefaultLang($pr[0]);
                $object->save();
                
                if (is_array($pr))
                {
                    foreach($pr as $key => $lang)
                    {
                        if ($object->hasLsiIn($lang))
                        {
                            $sql = "UPDATE EMT_AUTHOR_I18N 
                                    SET id=:id, culture=:culture, display_name=:display_name, stripped_display_name=:stripped_display_name, title=:title, introduction=:introduction
                                    WHERE id=".$object->getId()." AND culture=:culture
                            ";
                        }
                        else
                        {
                            $sql = "INSERT INTO EMT_AUTHOR_I18N 
                                    (id, culture, display_name, stripped_display_name, title, introduction)
                                    VALUES
                                    (:id, :culture, :display_name, :stripped_display_name, :title, :introduction)
                            ";
                        }
                        
                        $content = $params->get("auth_content_$key");
                        $stmt = $con->prepare($sql);
                        $stmt->bindValue(':id', $object->getId());
                        $stmt->bindValue(':culture', $lang);
                        $stmt->bindValue(':display_name', $params->get("auth_display_name_$key"));
                        $stmt->bindValue(':stripped_display_name', myTools::stripText($params->get("auth_display_name_$key")));
                        $stmt->bindValue(':title', $params->get("auth_title_$key"));
                        $stmt->bindValue(':introduction', $params->get("auth_introduction_$key"));
                        $stmt->execute();
                    }
                }
                if (!$object->isNew() && count($diff = array_diff($i18ns, $pr))) $object->removeI18n($diff);
                            
                // Check if uploaded a new file
                $filename = $request->getFileName('auth_file');
                if ($filename)
                    MediaItemPeer::createMediaItem($object->getId(), PrivacyNodeTypePeer::PR_NTYP_AUTHOR, MediaItemPeer::MI_TYP_AUTHOR_PHOTO, $_FILES['auth_file'], false);

                $con->commit();
                
                $object->reload();
                return $object;
            }
            catch(Exception $e)
            {
                $con->rollBack();

                return $object;
            }
        }
        return null;
    }
}
