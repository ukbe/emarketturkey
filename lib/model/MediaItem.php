<?php

class MediaItem extends BaseMediaItem
{
    private $hash = null;
    
    protected $imgLoaders = array(
        'image/jpeg'  => 'imagecreatefromjpeg',
        'image/pjpeg' => 'imagecreatefromjpeg',
        'image/png'   => 'imagecreatefrompng',
        'image/gif'   => 'imagecreatefromgif',
    );
    
    protected $imgCreators = array(
        'image/jpeg'  => 'imagejpeg',
        'image/pjpeg' => 'imagejpeg',
        'image/png'   => 'imagepng',
        'image/gif'   => 'imagegif',
    );
    
    protected $imgQualities = array(
        'image/jpeg'  => 100,
        'image/pjpeg' => 100,
        'image/png'   => 0,
        'image/gif'   => null,
    );
    
    public function __toString()
    {
        return $this->getDefineText(sfContext::getInstance()->getUser()->getUser());
    }
    
    public function getObjectTypeId()
    {
        return PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM;
    }
    
    public function getHash($reverse = false)
    {
        return is_null($this->hash) ? $this->hash = myTools::flipHash($this->getId(), false, $this->getObjectTypeId()) : $this->hash;
    }

    public function getPlug()
    {
        return base64_encode($this->getObjectTypeId() . '|' . $this->getHash());
    }

    public function getOriginalFileUri()
    {
        $conf = sfConfig::get('app_vault_domain');
        return $conf[sfContext::getInstance()->getConfiguration()->getEnvironment()]."/content/".$this->getOwnerTypeId()."/".$this->getOwnerId()."/".$this->getGuid().'.'.$this->getFileExtention();
    }

    public function getUri($size = MediaItemPeer::LOGO_TYPE_LARGE)
    {
        $conf = sfConfig::get('app_vault_domain');
        $sizestr = MediaItemPeer::$namingSuffixes[$size];
        return $conf[sfContext::getInstance()->getConfiguration()->getEnvironment()]."/content/".$this->getOwnerTypeId()."/".$this->getOwnerId()."/".$sizestr[0].$this->getGuid().$sizestr[1].'.'.$this->getFileExtention();
    }

    public function getMediumUri()
    {

        $conf = sfConfig::get('app_vault_domain');
        return $conf[sfContext::getInstance()->getConfiguration()->getEnvironment()]."/content/".$this->getOwnerTypeId()."/".$this->getOwnerId()."/M/".$this->getGuid().'M.'.$this->getFileExtention();
    }

    public function getThumbnailUri()
    {
        $conf = sfConfig::get('app_vault_domain');
        return $conf[sfContext::getInstance()->getConfiguration()->getEnvironment()]."/content/".$this->getOwnerTypeId()."/".$this->getOwnerId()."/S/".$this->getGuid().'S.'.$this->getFileExtention();
    }

    public function getUncroppedThumbUri()
    {
        $conf = sfConfig::get('app_vault_domain');
        return $conf[sfContext::getInstance()->getConfiguration()->getEnvironment()]."/content/".$this->getOwnerTypeId()."/".$this->getOwnerId()."/".$this->getGuid().'-uc.'.$this->getFileExtention();
    }

    public function getPath($withTypeCode=true)
    {
        $conf = sfConfig::get('app_vault_path');
        return $conf[sfContext::getInstance()->getConfiguration()->getEnvironment()]."/content/".$this->getOwnerTypeId()."/".$this->getOwnerId()."/".$this->getGuid().($withTypeCode?'L.':'.').$this->getFileExtention();
    }

    public function getOriginalFilePath()
    {
        return $this->getPath(false);
    }

    public function getMediumPath($withTypeCode=true)
    {
        $conf = sfConfig::get('app_vault_path');
        return $conf[sfContext::getInstance()->getConfiguration()->getEnvironment()]."/content/".$this->getOwnerTypeId()."/".$this->getOwnerId()."/M/".$this->getGuid().($withTypeCode?'M.':'.').$this->getFileExtention();
    }
    
    public function getThumbnailPath($withTypeCode=true)
    {
        $conf = sfConfig::get('app_vault_path');
        return $conf[sfContext::getInstance()->getConfiguration()->getEnvironment()]."/content/".$this->getOwnerTypeId()."/".$this->getOwnerId()."/S/".$this->getGuid().($withTypeCode?'S.':'.').$this->getFileExtention();
    }
    
    public function getUncroppedThumbPath($withTypeCode=true)
    {
        $conf = sfConfig::get('app_vault_path');
        return $conf[sfContext::getInstance()->getConfiguration()->getEnvironment()]."/content/".$this->getOwnerTypeId()."/".$this->getOwnerId()."/".$this->getGuid().($withTypeCode?'-uc.':'.').$this->getFileExtention();
    }
    
    public function getIcon()
    {
        $icons = sfConfig::get('app_file_extension_icons');
        $ext = strtolower($this->getFileExtention());
        if (isset($icons[$ext]))
        {
            return $icons[$ext];
        }
        else
        {
            return $icons['default'];
        }
    }
    
    public function delete(PropelPDO $con = null)
    {
        try
        {
            if (file_exists($this->getThumbnailPath())) unlink($this->getThumbnailPath());
            if (file_exists($this->getMediumPath())) unlink($this->getMediumPath());
            if (file_exists($this->getPath())) unlink($this->getPath());
            
            $c = new Criteria();
            $c->add(ActionLogPeer::OBJECT_ID, $this->getId());
            $c->add(ActionLogPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM);
            $mis = ActionLogPeer::doSelect($c);
            foreach ($mis as $mi)
            {
                $mi->delete();
            }
        }
        catch (Exception $e)
        {
            ErrorLogPeer::Log($this->getId(), PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM, 'on delete: '.$e->getMessage());
        }
        
        parent::delete($con);
    }
    
    public function store($fhandle)
    {
        if (!is_dir(dirname($this->getPath()))) mkdir(dirname($this->getPath()), 0777, true);

        move_uploaded_file($fhandle, $this->getOriginalFilePath());
        
        if (!file_exists($this->getOriginalFilePath()))
        {
            if (copy($fhandle, $this->getOriginalFilePath())) {
                    unlink($fhandle);
            }            
        }
        
        if (!$this->getIsTemp())
        {
            $this->sampleFiles();
        }
    }
    
    public function sampleFiles()
    {
        if ($this->getMimeType() && ($type = explode('/', $this->getMimeType())) && $type[0] != 'image') return;
        
        $c  = sfConfig::get('app_photoConfig_size');
        $c  = $c[$this->getItemTypeId()];
        $i = getimagesize($this->getOriginalFilePath());
        list($i['w'], $i['h']) = $i;

        $crop = null;
        parse_str($this->getOffsetCoords(), $coords);
        
        $matrix = array('large' => array('file' => $this->getPath()), 'medium' => array('file' => $this->getMediumPath()), 'small' => array('file' => $this->getThumbnailPath()));
        
        $loader = $this->imgLoaders[$i['mime']];
        $ms = $loader($this->getOriginalFilePath());
        
        parse_str($this->getOffsetCoords(), $coords);

        $trans_index = imagecolortransparent($ms);
        if($trans_index!=(-1)) $trans_color = imagecolorsforindex($ms,$trans_index);
        
        foreach ($matrix as $size => $prefs)
        {
            $crop = ((isset($c[$size]['crop']) && $c[$size]['crop'] == true) 
            || (!isset($c[$size]['crop']) && 
            isset($c['crop']) && $c['crop'] == true));

            if (!is_dir(dirname($prefs['file']))) mkdir(dirname($prefs['file']), 0777, true);

            $ks = imagecreatetruecolor($c[$size]['width'], $c[$size]['height']);

            if(!empty($trans_color))
            {
                $trans_new = imagecolorallocate($ks, $trans_color['red'], $trans_color['green'], $trans_color['blue']);
                $trans_new_index = imagecolortransparent($ks, $trans_new);
                imagefill($ks, 0, 0, $trans_new_index);
            }
            else
            {
                $trans_new = imagecolorallocate($ks, 255, 255, 255);
                imagefill($ks, 0, 0, $trans_new);
            }
            
            if ($crop && $i['w'] >= $c[$size]['width'] && $i['h'] >= $c[$size]['height'])
            {
                if (count($coords))
                {
                    imagecopyresampled($ks, $ms, 0, 0, $coords['x']/$coords['zoom'], $coords['y']/$coords['zoom'], $c[$size]['width'],  $c[$size]['height'], $coords['w']/$coords['zoom'], $coords['h']/$coords['zoom']);
                }
                else
                {
                    $r = $i['w'] / $i['h'];
                    $rc = $c[$size]['width'] / $c[$size]['height'];
                    $m = $r > $rc ? $c[$size]['height']/$i['h'] : $c[$size]['width']/$i['w'];
                    $p = $m > 1 ? array(($c[$size]['width']-$i['w'])/2, ($c[$size]['height']-$i['h'])/2)
                                 : array(($c[$size]['width']-$i['w']*$m)/2, ($c[$size]['height']-$i['h']*$m)/2);
                    if ($m > 1) $m = 1;
                    
                    imagecopyresampled($ks, $ms, $p[0], $p[1], 0, 0, $i['w']*$m, $i['h']*$m, $i['w'], $i['h']);
                }
            }
            else
            {
                $r = $i['w'] / $i['h'];
                $rc = $c[$size]['width'] / $c[$size]['height'];
                $m = $r > $rc ? $c[$size]['width']/$i['w'] : $c[$size]['height']/$i['h'];
                $p = $m > 1 ? array(($c[$size]['width']-$i['w'])/2, ($c[$size]['height']-$i['h'])/2)
                             : array(($c[$size]['width']-$i['w']*$m)/2, ($c[$size]['height']-$i['h']*$m)/2);
                if ($m > 1) $m = 1;
                
                imagecopyresampled($ks, $ms, $p[0], $p[1], 0, 0, $i['w']*$m, $i['h']*$m, $i['w'], $i['h']);
            }
            
            $creator = $this->imgCreators[$i['mime']];
            $creator($ks, $prefs['file'], $this->imgQualities[$i['mime']]);
            imagedestroy($ks);
        }
        imagedestroy($ms);
    }
    
    public function isHorizontal()
    {
        $dim = getimagesize($this->getOriginalFilePath());
        return $dim[0]/$dim[1] > 1;
    }
    
    public function regenerateFromOrig()
    {
        $this->store($this->getOriginalFilePath());
    }
    
    public function getOwner()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getOwnerId(), $this->getOwnerTypeId());
    }
    
    public static function get_limited_dims($od, $td, $minimal=true)
    {
        // $od = original dims, $ot = target dims
        if (!$td) return array($od['width'], $od['height']);
        $ar = $od['width']/$od['height'];
        
        $dim = array($od['width'], $od['height']);
        
        if ($ar > 1 && $od['width']>$td['width'])
        {
            $dim = ($minimal ? array($td['width'], $td['width'] / $ar) : array($td['height'] * $ar, $td['height']));
        }
        elseif ($ar < 1 && $od['height']>$td['height'])
        {
            $dim = ($minimal ? array($td['height'] * $ar, $td['height']) : array($td['width'], $td['width'] / $ar));
        }
        elseif ($ar == 1 && $od['width']>$td['width'])
        {
            $dim = array($td['width'], $td['height']);
        }
        
        return $dim;
    }
    
    public function getNext($circular = true)
    {
        $folder = $this->getMediaItemFolder();
        if ($folder)
        {
            $items = $folder->getItems();
        }
        else
        {
            $con = Propel::getConnection();
            $sql = "SELECT * FROM EMT_MEDIA_ITEM
                    WHERE OWNER_TYPE_ID=".$this->getOwnerTypeId(). " AND
                          OWNER_ID=".$this->getOwnerId(). " AND
                          (ITEM_TYPE_ID=".$this->getItemTypeId(). ($this->getItemTypeId()==MediaItemPeer::MI_TYP_LOGO ? " OR ITEM_TYPE_ID=".MediaItemPeer::MI_TYP_ALBUM_PHOTO : '') .  ") AND
                          " .($this->getFolderId() ? "FOLDER_ID=".$this->getFolderId() : "FOLDER_ID IS NULL") . "
                    ORDER BY CREATED_AT ASC
                    ";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $items = MediaItemPeer::populateObjects($stmt);
        }
        $index = 0;
        foreach ($items as $item)
        {
            if ($item->getId()==$this->getId()) break;
            $index++;
        }
        return array_key_exists($index+1, $items)?$items[$index+1]:($circular ? $items[0] : null);
    }
    
    public function getPrevious($circular = true)
    {
        $folder = $this->getMediaItemFolder();
        if ($folder)
        {
            $items = $folder->getItems();
        }
        else
        {
            $con = Propel::getConnection();
            $sql = "SELECT * FROM EMT_MEDIA_ITEM
                    WHERE OWNER_TYPE_ID=".$this->getOwnerTypeId(). " AND
                          OWNER_ID=".$this->getOwnerId(). " AND
                          (ITEM_TYPE_ID=".$this->getItemTypeId(). ($this->getItemTypeId()==MediaItemPeer::MI_TYP_LOGO ? " OR ITEM_TYPE_ID=".MediaItemPeer::MI_TYP_ALBUM_PHOTO : '') .  ") AND
                          " .($this->getFolderId() ? "FOLDER_ID=".$this->getFolderId() : "FOLDER_ID IS NULL") . "
                    ORDER BY CREATED_AT ASC
                    ";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $items = MediaItemPeer::populateObjects($stmt);
        }
        $index = 0;
        foreach ($items as $item)
        {
            if ($item->getId()==$this->getId()) break;
            $index++;
        }
        return array_key_exists($index-1, $items)?$items[$index-1]:($circular ? array_pop($items) : null);
    }
    
    public function getIndex()
    {
        $con = Propel::getConnection();
        $sql = "SELECT RNM FROM
                (   SELECT ROWNUM RNM, ID FROM 
                    (
                        SELECT ROWNUM RNM, ID FROM EMT_MEDIA_ITEM
                        WHERE OWNER_TYPE_ID=".$this->getOwnerTypeId(). " AND
                              OWNER_ID=".$this->getOwnerId(). " AND
                              (ITEM_TYPE_ID=".$this->getItemTypeId(). ($this->getItemTypeId()==MediaItemPeer::MI_TYP_LOGO ? " OR ITEM_TYPE_ID=".MediaItemPeer::MI_TYP_ALBUM_PHOTO : '') .  ") AND
                              " .($this->getFolderId() ? "FOLDER_ID=".$this->getFolderId() : "FOLDER_ID IS NULL") . "
                        ORDER BY CREATED_AT
                    )
                )
                WHERE ID={$this->getId()}
               ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
    
    public function getUrl($options = null)
    {
        $options = is_array($options) ? $options : array();
        switch ($this->getItemTypeId())
        {
            case MediaItemPeer::MI_TYP_ALBUM_PHOTO : return $this->getOwner()->getPhotosUrl("pid=".$this->getGuid());
            case MediaItemPeer::MI_TYP_PRODUCT_PICTURE : return $this->getOwner()->getPhotoUrl(isset($options['standalone']) ? $options['standalone'] : null, $this->getGuid());
            case MediaItemPeer::MI_TYP_LOGO : return method_exists($this->getOwner(),'getProfileUrl') ? $this->getOwner()->getProfileUrl() : $this->getOwner()->getUrl();
        }
        return "";
    }

    public function getDefineText($to_user = null, $target_culture = null)
    {
        if (!$to_user) $to_user = sfContext::getInstance()->getUser()->getUser();
        $top_owner = PrivacyNodeTypePeer::getTopOwnerOf($this);
        $is_owner = ($top_owner && $to_user->getId() == $top_owner->getId()) ? true : false;
        $owner = $this->getOwner();

        $i18n = sfContext::getInstance()->getI18N();
        $cl = $i18n->getCulture();
        if ($target_culture)
        {
            $culture = $target_culture;
            $i18n->setCulture($culture);
        }
        else
        {
            $culture = $cl;
        }

        $result = "a media item";
        
        switch ($this->getItemTypeId())
        {
            case MediaItemPeer::MI_TYP_ALBUM_PHOTO :
                $owner_type = PrivacyNodeTypePeer::getTypeFromClassname($owner);
                if ($owner_type == PrivacyNodeTypePeer::PR_NTYP_USER)
                {
                    $result = $is_owner ? $i18n->__("a photo of you") : $i18n->__("a photo of %1u", array('%1u' => $top_owner, 'sf_culture' => $culture));
                }
                elseif ($owner_type == PrivacyNodeTypePeer::PR_NTYP_COMPANY)
                {
                    
                }
                elseif ($owner_type == PrivacyNodeTypePeer::PR_NTYP_GROUP)
                {
                    
                }
                break;
            case MediaItemPeer::MI_TYP_COMPANY_HR_LOGO :
                $result = $is_owner ? $i18n->__("human resources logo of your company %1c", array('%1c' => $owner)) : $i18n->__("human resources logo of %1u's company %2c", array('%1u' => $top_owner, '%2c' => $owner, 'sf_culture' => $culture));
                break;
            case MediaItemPeer::MI_TYP_PRODUCT_PICTURE :
                $result = $is_owner ? $i18n->__("photo of your product %1p", array('%1p' => $owner)) : $i18n->__("photo of %1c's product %2p", array('%1c' => $owner->getOwner(), '%2p' => $owner, 'sf_culture' => $culture));
                break;
            case MediaItemPeer::MI_TYP_LOGO :
                $owner_type = PrivacyNodeTypePeer::getTypeFromClassname($owner);
                if ($owner_type == PrivacyNodeTypePeer::PR_NTYP_COMPANY)
                {
                    $result = $is_owner ? $i18n->__("logo of your company %1c", array('%1c' => $owner)) : $i18n->__("logo of %1u's company %2p", array('%1u' => $owner->getOwner(), '%2c' => $owner, 'sf_culture' => $culture));
                }
                elseif ($owner_type ==PrivacyNodeTypePeer::PR_NTYP_GROUP)
                {
                    $result = $is_owner ? $i18n->__("logo of your group %1g", array('%1p' => $owner)) : $i18n->__("logo of group %1g", array('%1g' => $owner, 'sf_culture' => $culture));
                }
                break;
            case MediaItemPeer::MI_TYP_PUBLICATION_PHOTO :
                $pub_type = $owner->getTypeId();
                if ($pub_type == PublicationPeer::PUB_TYP_ARTICLE)
                {
                    $result = $is_owner ? $i18n->__("photo of your article %1a", array('%1a' => $owner)) : $i18n->__("photo of %1u's article %2a", array('%1u' => $owner->getOwner(), '%2a' => $owner, 'sf_culture' => $culture));
                }
                elseif ($pub_type == PublicationPeer::PUB_TYP_NEWS)
                {
                    $result = $is_owner ? $i18n->__("photo of your news story %1n", array('%1n' => $owner)) : $i18n->__("photo of %1u's new story %2n", array('%1u' => $owner->getOwner(), '%2n' => $owner, 'sf_culture' => $culture));
                }
                break;
        }
        if ($target_culture) $i18n->setCulture($cl);
        return $result;
    }
    
    public function getOffsetCoord($key)
    {
        parse_str($this->getOffsetCoords(), $coord);
        return isset($coord[$key]) ? $coord[$key] : null;
    }
}
