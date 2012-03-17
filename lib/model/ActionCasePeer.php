<?php

class ActionCasePeer extends BaseActionCasePeer
{
    public static function getActionCaseIdByTypes($issuer_type, $action_id, $target_type = null)
    {
        $con = Propel::getConnection();
        $sql = "SELECT ID FROM EMT_ACTION_CASE 
                WHERE ISSUER_TYPE_ID=$issuer_type AND ACTION_ID=$action_id" . 
                ($target_type ? " AND TARGET_TYPE_ID=$target_type" : "");
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN, 0);
    }
    
}
