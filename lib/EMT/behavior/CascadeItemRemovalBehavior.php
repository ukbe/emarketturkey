<?php
class CascadeItemRemovalBehavior
{
    public static function postDelete($object, $con = null)
    {
        $classname = get_class($object);
        
        switch ($classname)
        {
            case "Product" :
                try
                {
                    $c = new Criteria();
                    $c->add(MediaItemPeer::OWNER_ID, $object->getId());
                    $c->add(MediaItemPeer::OWNER_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_PRODUCT);
                    $mis = MediaItemPeer::doSelect($c);
                    foreach ($mis as $mi)
                    {
                        $mi->delete();
                    }
                }
                catch (Exception $e)
                {
                    ErrorLogPeer::Log($object->getId(), PrivacyNodeTypePeer::PR_NTYP_PRODUCT, 'Could not cascade MediaItems on delete: '.$e->getMessage());
                }
                break;
            case "Company" :
                
                break;
            case "MediaItem" :
                try
                {
                    $c = new Criteria();
                    $c->add(ActionLogPeer::OBJECT_ID, $object->getId());
                    $c->add(ActionLogPeer::OBJECT_TYPE_ID, PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM);
                    $mis = ActionLogPeer::doSelect($c);
                    foreach ($mis as $mi)
                    {
                        $mi->delete();
                    }
                }
                catch (Exception $e)
                {
                    ErrorLogPeer::Log($object->getId(), PrivacyNodeTypePeer::PR_NTYP_MEDIA_ITEM, 'Could not cascade ActionLogs on delete: '.$e->getMessage());
                }
                break;
        }
        
        return true;
    }
    
}
?>