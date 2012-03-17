<?php

class RoleMatrixPeer extends BaseRoleMatrixPeer
{
    
    public static function getRelationsAvailableTo($subject_type, $object_type)
    {
        $con = Propel::getConnection();
        $sql = "select id from emt_role_matrix
                where object_type_id=$object_type and subject_type_id=$subject_type and is_relation_type=1";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }
}
