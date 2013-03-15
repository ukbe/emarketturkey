<?php

class PublicationPeer extends BasePublicationPeer
{
    CONST PUB_TYP_ARTICLE       = 1;
    CONST PUB_TYP_NEWS          = 2;
    
    CONST PUB_FEATURED_BANNER   = 1;
    CONST PUB_FEATURED_COLUMN   = 2;
    
    public static function retrieveByStrippedTitle($title, $ignore_culture = false)
    {
        $c = new Criteria();
        $c->add(PublicationI18nPeer::STRIPPED_TITLE, $title);
        if ($ignore_culture)
        {
            $pubs = PublicationI18nPeer::doSelect($c);
        }
        else
        {
            $pubs = self::doSelectWithI18n($c);
        }
        if (is_array($pubs) && count($pubs))
        {
            return $ignore_culture ? $pubs[0]->getPublication() : $pubs[0];
        }
        else
        {
            return null;
        }
    }
    
    public static function doSelectByTypeId($type_id = null, $include_inactive = false, $category_id = null, $limit = null, $featured_type = null, $include_sub_categories = false)
    {
        $con = Propel::getConnection();
        $sql = "
            SELECT DISTINCT EMT_PUBLICATION.* FROM EMT_PUBLICATION
            LEFT JOIN EMT_PUBLICATION_I18N ON EMT_PUBLICATION.ID=EMT_PUBLICATION_I18N.ID
            LEFT JOIN
            (
                select connect_by_root id spoint, id, active, level lvl from emt_publication_category
                start with parent_id=0
                connect by nocycle prior id = parent_id
            ) HCATS ON EMT_PUBLICATION.CATEGORY_ID=HCATS.ID
            WHERE EMT_PUBLICATION_I18N.CULTURE=:culture
            AND HCATS.ACTIVE=1
            ".($type_id ? "AND EMT_PUBLICATION.TYPE_ID=:type_id" : '')."
            ".($featured_type ? "AND EMT_PUBLICATION.FEATURED_TYPE=:featured_type" : '')."
            ".(!$include_inactive ? "AND EMT_PUBLICATION.ACTIVE=1" : '')."
            ".($category_id ? ($include_sub_categories ? "AND HCATS.SPOINT=:category_id" : "AND HCATS.ID=:category_id") : '')."
            ORDER BY EMT_PUBLICATION.CREATED_AT DESC
        ";
        if ($limit)
        {
            $sql = "SELECT * FROM ($sql) WHERE ROWNUM<=:limit";
        }
        
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':culture', sfContext::getInstance()->getUser()->getCulture());
        if ($type_id) $stmt->bindValue(':type_id', $type_id);
        if ($featured_type) $stmt->bindValue(':featured_type', $featured_type);
        if ($category_id) $stmt->bindValue(':category_id', $category_id);
        if ($limit) $stmt->bindValue(':limit', $limit);
        $stmt->execute();
        return PublicationPeer::populateObjects($stmt);
    }
    
    public static function doSelectArticles($include_inactive = false, $category_id = null, $feature_type = null)
    {
        return self::doSelectByTypeId(PublicationPeer::PUB_TYP_ARTICLE, $include_inactive, $category_id, $feature_type);
    }

    public static function doSelectNews($include_inactive = false, $category_id = null, $feature_type = null)
    {
        return self::doSelectByTypeId(PublicationPeer::PUB_TYP_NEWS, $include_inactive, $category_id, $feature_type);
    }

    public static function doSelectArticlesByCategory($include_inactive = false, $categories = array(), $featured_type = null)
    {
        $news = array();
        foreach ($categories as $cat)
        {
            $news[$cat] = self::doSelectByTypeId(self::PUB_TYP_ARTICLE, $include_inactive, $cat, 4, $featured_type);
        }
        return $news;
    }

    public static function doSelectNewsByCategory($include_inactive = false, $categories = array(), $featured_type = null, $limit_cols = null, $limit_rows = 4, $include_sub_categories = false)
    {
        $news = array();
        foreach ($categories as $key => $cat)
        {
            if (isset($limit_cols) && $key > $limit_cols) break;
            $news[$cat] = self::doSelectByTypeId(self::PUB_TYP_NEWS, $include_inactive, $cat, $limit_rows, $featured_type, $include_sub_categories);
        }
        return $news;
    }

    public static function retrieveArticleById($id)
    {
        $c = new Criteria();
        $c->add(PublicationPeer::TYPE_ID, PublicationPeer::PUB_TYP_ARTICLE);
        $c->add(PublicationPeer::ID, $id);
        return PublicationPeer::doSelectOne($c);
    }

    public static function retrieveNewsById($id)
    {
        $c = new Criteria();
        $c->add(PublicationPeer::TYPE_ID, PublicationPeer::PUB_TYP_NEWS);
        $c->add(PublicationPeer::ID, $id);
        return PublicationPeer::doSelectOne($c);
    }

    public static function getPager($page, $items_per_page = 20, $c1 = null, $author_id= null, $type_id = null, $source_id = null, $category_id = null, $status = null)
    {
        if ($c1 instanceof Criteria)
        {
            $c = clone $c1;
        }
        else
        {
            $c = new Criteria();
        }

        if (isset($status)) $c->add(PublicationPeer::ACTIVE, $status);
        if (isset($type_id)) $c->add(PublicationPeer::TYPE_ID, $type_id);
        if (isset($author_id)) $c->add(PublicationPeer::AUTHOR_ID, $author_id);
        if (isset($source_id)) $c->add(PublicationPeer::SOURCE_ID, $source_id);
        if (isset($category_id)) $c->add(PublicationPeer::CATEGORY_ID, $category_id);

        $pager = new sfPropelPager('Publication', $items_per_page);
        $pager->setPage($page);
        $pager->setCriteria($c);
        $pager->init();
        return $pager;
    }

    public static function getInstance($params, $author = null, $new = false)
    {
        if ($new)
        {
            $obj = new Publication();
            if ($author instanceof Author){
                $obj->setAuthorId($author->getId());
                $obj->setTypeId($params->get('_object_type_id'));
            }
        }
        else
        {
            $c = new Criteria();
            $c->add(PublicationPeer::ID, $params->get('id'));
            if ($author) $c->add(PublicationPeer::AUTHOR_ID, $author->getId());
            $obj = self::doSelectOne($c);
        }
        if ($type_id = $params->get('_object_type_id')) $obj->setTypeId($type_id);
        return $obj;
    }

    public static function validate($params, $author = null, $request)
    {
        $categories = array_filter($cats = $params->get('category_id', array()));
        $category = PublicationCategoryPeer::retrieveByPK(array_pop($categories));
        $post_author = AuthorPeer::retrieveByPK($params->get('author_id'));
        $post_source = PublicationSourcePeer::retrieveByPK($params->get('source_id'));

        if (!(3 < strlen($params->get("article_name")) && 
                  strlen($params->get("article_name")) < 256)) $request->setError("article_name", 'Please enter an article name.');
        
        if ($author && $author->getId() != $params->get('author_id'))
            $request->setError("author_id", 'Invalid author assignment.');
        else if (!$post_author) $request->setError("author_id", 'Please select an author.');
        
        if (!$category) $request->setError("category_id", 'Please select a category.');
        if (!$post_source) $request->setError("source_id", 'Please select a publication source.');

        sfLoader::loadHelpers('I18N');
        
        $pr = $params->get('article_lang');

        foreach ($pr as $key => $lang)
        {
            $lang = trim($lang);
            if ($lang == '')
                $request->setError("article_lang_$key", __('Please select a language which you will provide article content in.'));
            if (trim($request->getParameter("article_title_$key"))=='')
                $request->setError("article_title_$key", $lang ? __('Please enter an article title for %1 language.', array('%1' => format_language($lang))) : __('Please enter an article title.'));
            if (mb_strlen($request->getParameter("article_title_$key")) > 255)
                $request->setError("article_title_$key", $lang ? __('Article title for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 255)) : __('Article title must be maximum %1 characters long.', array('%1' => 255)));
            if (mb_strlen($request->getParameter("article_stitle_$key")) > 60)
                $request->setError("article_stitle_$key", $lang ? __('Article short title for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 60)) : __('Article short title must be maximum %1 characters long.', array('%1' => 60)));
            if (trim($request->getParameter("article_summary_$key"))=='')
                $request->setError("article_summary_$key", $lang ? __('Please enter an article summary for %1 language.', array('%1' => format_language($lang))) : __('Please enter an article summary.'));
            if (mb_strlen($request->getParameter("article_summary_$key")) > 100)
                $request->setError("article_summary_$key", $lang ? __('Article summary for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 100)) : __('Article summary must be maximum %1 characters long.', array('%1' => 100)));
            if ($request->getParameter("article_introduction_$key")=='')
                $request->setError("article_introduction_$key", $lang ? __('Please enter an article introduction for %1 language.', array('%1' => format_language($lang))) : __('Please enter article introduction.'));
            if (mb_strlen($request->getParameter("article_introduction_$key")) > 512)
                $request->setError("article_introduction_$key", $lang ? __('Article introduction for %1 language must be maximum %2 characters long.', array('%1' => format_language($lang), '%2' => 512)) : __('Article introduction must be maximum %1 characters long.', array('%1' => 512)));
            if (trim($request->getParameter("article_content_$key"))=='')
                $request->setError("article_content_$key", $lang ? __('Please enter an article content for %1 language.', array('%1' => format_language($lang))) : __('Please enter article content.'));
        }
                  
        return !$request->hasErrors();
    }
    
    public static function saveInstance($object, $params, $owner = null, $request)
    {
        if ($object instanceof Publication)
        {
            $con = Propel::getConnection();
    
            try
            {
                $i18ns = $object->getExistingI18ns();
                $cats = array_filter($params->get('category_id'));

                $con->beginTransaction();
                
                $object->setName($params->get('article_name'));
                $object->setSourceId($params->get('source_id'));
                $object->setCategoryId(array_pop($cats));
                if ($owner instanceof Author) $object->setAuthorId($owner->getId()); 
                else $object->setAuthorId($params->get('author_id'));
                $object->setActive($params->get('article_active'));
                
                $pr = $params->get('article_lang');
                $object->setDefaultLang($pr[0]);
                $object->save();
                
                if (is_array($pr))
                {
                    foreach($pr as $key => $lang)
                    {
                        if ($object->hasLsiIn($lang))
                        {
                            $sql = "UPDATE EMT_PUBLICATION_I18N 
                                    SET id=:id, culture=:culture, title=:title, stripped_title=:stripped_title, short_title=:short_title, summary=:summary, introduction=:introduction, content=:content
                                    WHERE id=:id AND culture=:culture
                            ";
                        }
                        else
                        {
                            $sql = "INSERT INTO EMT_PUBLICATION_I18N 
                                    (id, culture, title, stripped_title, short_title, summary, introduction, content)
                                    VALUES
                                    (:id, :culture, :title, :stripped_title, :short_title, :summary, :introduction, :content)
                            ";
                        }
                        
                        $content = $params->get("article_content_$key");
                        $stmt = $con->prepare($sql);
                        $stmt->bindValue(':id', $object->getId());
                        $stmt->bindValue(':culture', $lang);
                        $stmt->bindValue(':title', $params->get("article_title_$key"));
                        $stmt->bindValue(':stripped_title', myTools::url_slug($params->get("article_title_$key")));
                        $stmt->bindValue(':short_title', $params->get("article_stitle_$key"));
                        $stmt->bindValue(':summary', $params->get("article_summary_$key"));
                        $stmt->bindValue(':introduction', $params->get("article_introduction_$key"));
                        $stmt->bindParam(':content', $content, PDO::PARAM_STR, strlen($content));
                        $stmt->execute();
                    }
                }
                if (!$object->isNew() && count($diff = array_diff($i18ns, $pr))) $object->removeI18n($diff);
                            
                // Check if uploaded a new file
                $filename = $request->getFileName('article_file');
                if ($filename)
                    MediaItemPeer::createMediaItem($object->getId(), PrivacyNodeTypePeer::PR_NTYP_PUBLICATION, MediaItemPeer::MI_TYP_PUBLICATION_PHOTO, $_FILES['article_file'], false);

                $con->commit();
                
                $object->reload();
                return $object;
            }
            catch(Exception $e)
            {
                $con->rollBack();

                ErrorLogPeer::Log($object->getId() ? $object->getId() : 0, $object->getObjectTypeId(), "Error occured while saving Publication.", $e);

                return $object;
            }
        }
        return null;
    }
    
    public static function getColumnArticles($limit = 5, $category_id = null)
    {
        $con = Propel::getConnection();
        
        $sql = "SELECT * FROM 
                (
                    SELECT EMT_PUBLICATION.*, RANK() OVER (PARTITION BY EMT_PUBLICATION.AUTHOR_ID ORDER BY EMT_PUBLICATION.CREATED_AT DESC) SQNUM FROM EMT_PUBLICATION
                    LEFT JOIN EMT_PUBLICATION_I18N ON EMT_PUBLICATION.ID=EMT_PUBLICATION_I18N.ID
                    LEFT JOIN EMT_AUTHOR ON EMT_PUBLICATION.AUTHOR_ID=EMT_AUTHOR.ID
                    WHERE EMT_AUTHOR.IS_COLUMNIST=1 AND EMT_AUTHOR.FEATURED_TYPE=:auth_featured_type
                        AND EMT_AUTHOR.ACTIVE=1 AND EMT_PUBLICATION.ACTIVE=1 AND EMT_PUBLICATION.FEATURED_TYPE=:pub_featured_type
                        AND EMT_PUBLICATION.TYPE_ID=:type_id
                        ".($category_id ? "AND EMT_PUBLICATION.CATEGORY_ID=:category_id" : '')."
                        AND EMT_PUBLICATION_I18N.CULTURE=:culture
                )
                WHERE SQNUM=1 AND ROWNUM <= :limit
                ORDER BY UPDATED_AT DESC
                ";
        
        $stmt = $con->prepare($sql);
        if ($category_id) $stmt->bindValue(':category_id', $category_id);
        $stmt->bindValue(':auth_featured_type', AuthorPeer::AUTH_FEATURED_COLUMN);
        $stmt->bindValue(':pub_featured_type', PublicationPeer::PUB_FEATURED_COLUMN);
        $stmt->bindValue(':type_id', PublicationPeer::PUB_TYP_ARTICLE);
        $stmt->bindValue(':limit', $limit);
        $stmt->bindValue(':culture', sfContext::getInstance()->getUser()->getCulture());
        $stmt->execute();

        return PublicationPeer::populateObjects($stmt);
    }

    public static function getMostReadPublications($type_id = null, $limit = 5, $culture = null, $source_id = null, $author_id = null, $category_id = null, $except_pub_id = null)
    {
        $con = Propel::getConnection();

        $sql = "SELECT * FROM
                (
                    SELECT * FROM 
                    (
                        SELECT EMT_PUBLICATION.*, (SELECT COUNT(*) FROM EMT_RATING WHERE ITEM_ID=EMT_PUBLICATION.ID AND ITEM_TYPE_ID=".PrivacyNodeTypePeer::PR_NTYP_PUBLICATION.") RTING
                        FROM EMT_PUBLICATION
                        WHERE EMT_PUBLICATION.ACTIVE=1
                        ".($type_id ? " AND EMT_PUBLICATION.TYPE_ID=:type_id" : '')."
                        ".($culture ? "AND EXISTS (SELECT 1 FROM EMT_PUBLICATION_I18N WHERE ID=EMT_PUBLICATION.ID AND CULTURE=:culture)" : '')."
                        ".($source_id ? "AND EMT_PUBLICATION.SOURCE_ID=:source_id" : '')."
                        ".($author_id ? "AND EMT_PUBLICATION.AUTHOR_ID=:author_id" : '')."
                        ".($category_id ? "AND EMT_PUBLICATION.CATEGORY_ID=:category_id" : '')."
                        ".($except_pub_id ? "AND EMT_PUBLICATION.ID!=:except_pub_id" : '')."
                    )
                    WHERE RTING > 0
                    ORDER BY RTING DESC
                )
                WHERE ROWNUM <= :limit
            ";

        $stmt = $con->prepare($sql);
        if ($type_id) $stmt->bindValue(':type_id', $type_id);
        if ($culture) $stmt->bindValue(':culture', $culture);
        if ($source_id) $stmt->bindValue(':source_id', $source_id);
        if ($author_id) $stmt->bindValue(':author_id', $author_id);
        if ($category_id) $stmt->bindValue(':category_id', $category_id);
        if ($except_pub_id) $stmt->bindValue(':except_pub_id', $except_pub_id);
        $stmt->bindValue(':limit', $limit);
        $stmt->execute();

        return PublicationPeer::populateObjects($stmt);
    }
}
