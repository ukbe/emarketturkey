<?php

class MediaItemFolder extends BaseMediaItemFolder
{
    public function getItems($count = null, $random = false)
    {
        $con = Propel::getConnection();
        $sql = "
            SELECT * FROM EMT_MEDIA_ITEM
            WHERE FOLDER_ID={$this->getId()}
            ".($random?"ORDER BY dbms_random.value":"ORDER BY CREATED_AT ASC")."
        ";
        if ($count)
        {
            $count++;
            $sql = "SELECT * FROM ($sql) WHERE ROWNUM<$count";
        }
        $stmt = $con->prepare($sql);
        $stmt->execute();
        
        $items = MediaItemPeer::populateObjects($stmt);
        return $count == 2 ? (count($items) ? $items[0] : null) : $items;
    }

    public function getOwner()
    {
        return PrivacyNodeTypePeer::retrieveObject($this->getOwnerId(), $this->getOwnerTypeId());
    }
    
    public function getUrl()
    {
        switch ($this->getTypeId())
        {
            case MediaItemFolderPeer::MIF_TYP_ALBUM : return $this->getOwner()->getPhotosUrl("album=".$this->getId());
        }
        return "";
    }
    
    public function getDefineText($to_user, $culture)
    {
        $top_owner = PrivacyNodeTypePeer::getTopOwnerOf($this);
        $is_owner = ($top_owner && $to_user->getId() == $top_owner->getId()) ? true : false;
        $owner = $this->getOwner();
        
        $i18n = sfContext::getInstance()->getI18N();
        $cl = $i18n->getCulture();
        $i18n->setCulture($culture);

        $result = "a media folder";
        
        switch ($this->getTypeId())
        {
            case MediaItemFolderPeer::MIF_TYP_ALBUM :
                $owner_type = PrivacyNodeTypePeer::getTypeFromClassname($owner);
                switch ($owner_type)
                {
                    case PrivacyNodeTypePeer::PR_NTYP_USER : 
                        $result = $is_owner ? $i18n->__("an album of you", array('culture' => $culture)) : $i18n->__("an album of %1u", array('%1u' => $owner, 'sf_culture' => $culture));;
                        break;
                    case PrivacyNodeTypePeer::PR_NTYP_COMPANY :
                        $result = $is_owner ? $i18n->__("an album of your company %1c", array('%1c' => $owner, 'sf_culture' => $culture)) : $i18n->__("an album of %1u's company %2c", array('%1u' => $top_owner, '%2c' => $owner, 'sf_culture' => $culture));;
                        break;
                    case PrivacyNodeTypePeer::PR_NTYP_GROUP :
                        $result = $is_owner ? $i18n->__("an album of your group %1g", array('%1g' => $owner, 'sf_culture' => $culture)) : $i18n->__("an album of %1u's group %2g", array('%1u' => $top_owner, '%2g' => $owner, 'sf_culture' => $culture));;
                        break;
                }
        }
        $i18n->setCulture($cl);
        return $result;
    }
}