<?php

class MediaItemPeer extends BaseMediaItemPeer
{
    CONST MI_TYP_ALBUM_PHOTO                = 1;
    CONST MI_TYP_HARDCOPY_CV                = 2;
    CONST MI_TYP_RESUME_PHOTO               = 3;
    CONST MI_TYP_RESUME_PORTFOLIO_ITEM      = 4;
    CONST MI_TYP_VIDEO_CV                   = 5;
    CONST MI_TYP_PRODUCT_PICTURE            = 6;
    CONST MI_TYP_LOGO                       = 7;
    CONST MI_TYP_VIDEO                      = 8;
    CONST MI_TYP_PUBLICATION_PHOTO          = 9;
    CONST MI_TYP_HR_LOGO                    = 10;
    CONST MI_TYP_PLATFORM_AD_FILE           = 11;
    CONST MI_TYP_JOB_POST_IMAGE             = 12;
    CONST MI_TYP_BANNER_IMAGE               = 13;
    CONST MI_TYP_JOB_SPOTBOX_BACK           = 14;
    CONST MI_TYP_JOB_PLATINUM_IMAGE         = 15;
    CONST MI_TYP_JOB_RECTBOX_IMAGE          = 16;
    CONST MI_TYP_JOB_CUBEBOX_IMAGE          = 17;
    CONST MI_TYP_AUTHOR_PHOTO               = 18;
    CONST MI_TYP_PUBLICATION_SOURCE_PHOTO   = 19;
    CONST MI_TYP_PUBLICATION_CATEGORY_PHOTO = 20;
    CONST MI_TYP_VIDEO_PREVIEW              = 21;
    
    #Generic Versions
    CONST LOGO_TYP_SMALL                    = 1;
    CONST LOGO_TYPE_MEDIUM                  = 2;
    CONST LOGO_TYPE_LARGE                   = 3;
    CONST LOGO_TYPE_ORIGINAL                = 4;
    #Custom Versions
    CONST LOGO_TYPE_HOME_SMALL_RECT         = 4;
    CONST LOGO_TYPE_HOME_BANNER_RECT        = 5;
    CONST LOGO_TYPE_HOME_SMALL_SQUARE       = 6;

    CONST MI_NO_FOLDER                      = -1;
    
    public static $sizelabel = array(self::LOGO_TYP_SMALL     => 'small',
                                     self::LOGO_TYPE_MEDIUM   => 'medium',
                                     self::LOGO_TYPE_LARGE    => 'large',
                                     self::LOGO_TYPE_ORIGINAL => 'original',
                               );

    public static $typeNames    = array (1 => 'Album Photo',
                                         2 => 'Hardcopy CV',
                                         3 => 'Resume Photo',
                                         4 => 'Resume Portfolio Item',
                                         5 => 'Video CV',
                                         6 => 'Product Picture',
                                         7 => 'Logo',
                                         8 => 'Video',
                                         9 => 'Publication Photo',
                                         10 => 'Company HR Logo',
                                         11 => 'Platform Ad File',
                                         12 => 'Job Post Image',
                                         13 => 'Banner Image',
                                         14 => 'Job SpotBox Background',
                                         15 => 'Job PlatinumBox Image',
                                         16 => 'Job RectangleBox Image',
                                         17 => 'Job CubeBox Image',
                                         18 => 'Author Photo',
                                         19 => 'Publication Source Photo',
                                         20 => 'Publication Category Photo',
                                         21 => 'Video Preview',
                                         );
                                         
    public static $namingSuffixes = array(MediaItemPeer::LOGO_TYP_SMALL      => array('S/', 'S'),
                                          MediaItemPeer::LOGO_TYPE_MEDIUM    => array('M/', 'M'),
                                          MediaItemPeer::LOGO_TYPE_LARGE     => array('', 'L'),
                                          MediaItemPeer::LOGO_TYPE_HOME_SMALL_RECT => array('', 'SR'),
                                          MediaItemPeer::LOGO_TYPE_HOME_SMALL_SQUARE => array('', 'SQ'),
                                          MediaItemPeer::LOGO_TYPE_HOME_BANNER_RECT => array('', 'BN'),
                                          );

    public static function retrieveItemsFor($owner_id, $owner_type_id, $mi_type_id=null, $mi_id=null, $rand=false, $count = false, $page = null, $ipp = 20, $return_pager = false, $folder_id = null)
    {
        $joins = $wheres = array();

        $wheres[] = " (EMT_MEDIA_ITEM.OWNER_TYPE_ID=$owner_type_id AND EMT_MEDIA_ITEM.OWNER_ID=$owner_id) ";

        if ($folder_id == self::MI_NO_FOLDER)
        {
            $wheres[] = "(EMT_MEDIA_ITEM.FOLDER_ID IS NULL)";
        }
        elseif ($folder_id)
        {
            $wheres[] = "(EMT_MEDIA_ITEM.FOLDER_ID=$folder_id)";
        }
        
        if ($mi_type_id) $wheres[] = "EMT_MEDIA_ITEM.ITEM_TYPE_ID=$mi_type_id";
        if ($mi_id) $wheres[] = is_numeric($mi_id) ? "EMT_MEDIA_ITEM.ID=$mi_id" : "EMT_MEDIA_ITEM.GUID='$mi_id'";
        
        $sql = "SELECT EMT_MEDIA_ITEM.*
                FROM EMT_MEDIA_ITEM"
                . (count($joins) ? implode(' ', $joins) : "")
                . (count($wheres) ? " WHERE ". implode(' AND ', $wheres) : "");
        
        $sql .= $rand ? " ORDER BY dbms_random.value " : "";

        $pager = new EmtPager('MediaItem', $ipp);
        $pager->setSql($sql);
        $pager->setPage($page);
        $pager->init();
        return $return_pager ? $pager : $pager->getResults();
    }
    
    public static function createMediaItem($owner_id, $owner_type_id, $item_type_id, $tmppath, $is_temp = 0, $options = array())
    {
        switch ($item_type_id){
            case MediaItemPeer::MI_TYP_PRODUCT_PICTURE :
                break;
            default: 
        }
        $crop = isset($options['crop']) ? $options['crop'] : null;
        $coords = isset($options['coords']) ? $options['coords'] : null;
        $isuploaded = is_array($tmppath);
        $pathinfo = pathinfo($isuploaded ? $tmppath['name'] : $tmppath);
        $fileobj = new MediaItem();
        $fileobj->setFilename($pathinfo['basename']);
        $fileobj->setFileExtention($pathinfo['extension']);
        $fileobj->setFileSize(filesize($isuploaded ? $tmppath['tmp_name'] : $tmppath));
        $fileobj->setOwnerId($owner_id);
        $fileobj->setOwnerTypeId($owner_type_id);
        $fileobj->setItemTypeId($item_type_id);
        $fileobj->setIsTemp($is_temp);
        $fileobj->setOffsetCoords($coords);
        if ($finfo = finfo_open(FILEINFO_MIME_TYPE))
        {
            $mime_type = finfo_file($finfo, $isuploaded ? $tmppath['tmp_name'] : $tmppath);
            finfo_close($finfo);
            $fileobj->setMimeType($mime_type);
        }
        $fileobj->setCrop($crop);
        $fileobj->save();
        $fileobj->reload();
        $fileobj->store($isuploaded ? $tmppath['tmp_name'] : $tmppath, $options);
        return $fileobj;
    }
    
    public static function createMediaItemFromRemoteFile($owner_id, $owner_type_id, $item_type_id, $url, $is_temp = 0, $options = array())
    {
        $pathinfo = pathinfo($url);

        $tmppath = sys_get_temp_dir() . uniqid() . "." . (isset($pathinfo['extension']) ? $pathinfo['extension'] : 'jpg');
        
        $image = file_get_contents($url);
        file_put_contents($tmppath, $image);

        self::createMediaItem($owner_id, $owner_type_id, $item_type_id, $tmppath, $is_temp, $options);
    }
    
    public static function getDimensionsFor($type_id, $size = null)
    {
        $c  = sfConfig::get('app_photoConfig_size');
        $c  = $size ? $c[$type_id][self::$sizelabel[$size]] : $c[$type_id];
        return $c;
    }
    
}
