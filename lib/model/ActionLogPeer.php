<?php

class ActionLogPeer extends BaseActionLogPeer
{
    public static function Log($issuer, $action_id, $target = null, $object = null)
    {
        $con = Propel::getConnection();
        try
        {
            $con->beginTransaction();
            $issuer_type = PrivacyNodeTypePeer::getTypeFromClassname(get_class($issuer));
            $target_type = $target ? PrivacyNodeTypePeer::getTypeFromClassname(get_class($target)) : null;
            $object_type = $object ? PrivacyNodeTypePeer::getTypeFromClassname(get_class($object)) : null;
            
            $action_case_id = ActionCasePeer::getActionCaseIdByTypes($issuer_type, $action_id, $target_type);
            
            $log = new ActionLog();
            $log->setIssuerId($issuer->getId());
            if ($target) $log->setTargetId($target->getId());
            if ($object)
            {
                $log->setObjectId($object->getId());
                $log->setObjectTypeId($object_type);
            }
            if ($issuer_type != PrivacyNodeTypePeer::PR_NTYP_USER) $log->setUserId(sfContext::getInstance()->getUser()->getUser()->getId());
            $log->setActionCaseId($action_case_id);
            $log->save();
            $con->commit();
            return $log;
        }
        catch (Exception $e)
        {
            $con->rollBack();
            mail('ukbe.akdogan@emarketturkey.com', 'EMT:Event Log Exception', "Hi Pal,\n I could not log event \n reason:".$e->getMessage()."\n\n
                Issuer: ".print_r($issuer, true) ."\n
                ActionID: $action_id\n
                Target: ".print_r($target, true) ."\n
                Object: ".print_r($object, true) ."\n
                Referer: ".sfContext::getInstance()->getRequest()->getUri()
            );
            return null;
        }
    }
    
    public static function getActionLogs($issuer, $action_id = null, $target = null, $object = null, $order_asc = true, $items_per_page = 20, $page = 1)
    {
        $con = Propel::getConnection();
        $issuer_type = PrivacyNodeTypePeer::getTypeFromClassname(get_class($issuer));
        $target_type = $target ? PrivacyNodeTypePeer::getTypeFromClassname(get_class($target)) : null;
        $object_type = $object ? PrivacyNodeTypePeer::getTypeFromClassname(get_class($object)) : null;

        $action_case_id = ($action_id ?  ActionCasePeer::getActionCaseIdByTypes($issuer_type, $action_id, $target_type) : null);
        
        $sql = "SELECT * FROM
                (
                    SELECT DISTINCT * FROM 
                    (
                        SELECT EMT_ACTION_LOG.* FROM EMT_ACTION_LOG, EMT_ACTION_CASE, EMT_ACTION
                        WHERE 
                            EMT_ACTION_LOG.ACTION_CASE_ID=EMT_ACTION_CASE.ID AND EMT_ACTION_CASE.ACTION_ID=EMT_ACTION.ID
                            " . (isset($action_id) ? "AND EMT_ACTION.ID=".$action_id : "") . "
                            " . (isset($target) ? "AND (EMT_ACTION_CASE.TARGET_ID=$target_id AND EMT_ACTION_LOG.TARGET_ID=$target_type)" : "") . "
                            " . (isset($object) ? "AND (EMT_ACTION_CASE.OBJECT_ID=$object_id AND EMT_ACTION_LOG.OBJECT_ID=$object_type)" : "") . "
                            AND EMT_ACTION_LOG.ISSUER_ID={$issuer->getId()} AND EMT_ACTION_CASE.ISSUER_TYPE_ID=$issuer_type
                    )
                    ORDER BY CREATED_AT " . ($order_asc ? "ASC" : "DESC") . "
                )
                WHERE ROWNUM >= " . (($page-1)*$items_per_page) . " AND ROWNUM < " . ($page*$items_per_page) . "
               ";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return ActionLogPeer::populateObjects($stmt);
    }
}
