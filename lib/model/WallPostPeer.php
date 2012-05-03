<?php

class WallPostPeer extends BaseWallPostPeer
{
    
    public static $partials  = array(PrivacyNodeTypePeer::PR_NTYP_POST_STATUS        => 'profile/post-status',
                                     PrivacyNodeTypePeer::PR_NTYP_POST_LINK          => 'profile/post-link',
                                     PrivacyNodeTypePeer::PR_NTYP_POST_VIDEO         => 'profile/post-video',
                                     PrivacyNodeTypePeer::PR_NTYP_POST_LOCATION      => 'profile/post-location',
                                     PrivacyNodeTypePeer::PR_NTYP_POST_JOB           => 'profile/post-job',
                                     PrivacyNodeTypePeer::PR_NTYP_POST_OPPORTUNITY   => 'profile/post-opportunity',
                                 );
    
    public static function postItem($poster, $owner = null, $post_item, $audience = RolePeer::RL_ALL)
    {
        $con = Propel::getConnection();
        
        $owner = isset($owner) ? $owner : $poster;
        try
        {
            $con->beginTransaction();

            if ($post_item->isNew()) $post_item->save($con);
            
            $post = new WallPost();
            $post->setOwnerId($owner->getId());
            $post->setOwnerTypeId($owner->getObjectTypeId());
            $post->setPosterId($poster->getId());
            $post->setPosterTypeId($poster->getObjectTypeId());
            $post->setItemId($post_item->getId());
            $post->setItemTypeId($post_item->getObjectTypeId());
            $post->setTargetAudience($audience);
            $post->save();

            $con->commit();
        }
        catch (Exception $e)
        {
            $con->rollBack();
            return false;
        }
        return $post;
    }

}
