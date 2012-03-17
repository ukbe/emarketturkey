<?php

class CommentPeer extends BaseCommentPeer
{
    public $commentables        = Array(PrivacyNodeTypePeer::PR_NTYP_ACTION_LOG,
                                        PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM,
                                        PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM_FOLDER,
                                        PrivacyNodeTypePeer::PR_NTYP_POLL_ITEM,
                                        PrivacyNodeTypePeer::PR_NTYP_PUBLICATION,
                                        PrivacyNodeTypePeer::PR_NTYP_STATUS_UPDATE,
                                        PrivacyNodeTypePeer::PR_NTYP_LOCATION_UPDATE,
                                        PrivacyNodeTypePeer::PR_NTYP_REL_STAT_UPDATE);
                                        
    public static function isCommentable($object)
    {
        return in_array(is_numeric($object) ? $object : PrivacyNodeTypePeer::getTypeFromClassname($object), self::$commentables);
    }
    
    public static function getCommentsFor($item)
    {
        $type = PrivacyNodeTypePeer::getTypeFromClassname(get_class($item));
        if ($type)
        {
            $c = new Criteria();
            $c->add(CommentPeer::ITEM_ID, $item->getId());
            $c->add(CommentPeer::ITEM_TYPE_ID, $type);
            $c->add(CommentPeer::DELETED_AT, null, Criteria::ISNULL);
            $c->addAscendingOrderByColumn(CommentPeer::CREATED_AT);
            return self::doSelect($c);
        }
        return null;
    }

    public static function countCommentsFor($item)
    {
        $type = PrivacyNodeTypePeer::getTypeFromClassname(get_class($item));
        if ($type)
        {
            $c = new Criteria();
            $c->add(CommentPeer::ITEM_ID, $item->getId());
            $c->add(CommentPeer::ITEM_TYPE_ID, $type);
            $c->add(CommentPeer::DELETED_AT, null, Criteria::ISNULL);
            $c->addAscendingOrderByColumn(CommentPeer::CREATED_AT);
            return self::doCount($c);
        }
        return null;
    }
    
    public static function retrieveCommenters($item, $filter_ids = null)
    {
        $comments = self::getCommentsFor($item);
        $commenters = array();
        
        if (isset($filter_ids) && is_numeric($filter_ids)) $filter_ids = array($filter_ids);
        
        foreach ($comments as $comment)
        {
            if (($commenter = $comment->getCommenter()) && array_search($commenter, $commenters)===false && (!isset($filter_ids) || (is_array($filter_ids) && array_search($commenter->getId(), $filter_ids)===false)))
            {
                array_push($commenters, $commenter);
            }
        }
        return $commenters;
    }
}
