<?php

class EmailLayoutPeer extends BaseEmailLayoutPeer
{
    public static function getLayoutsFor($owner_id, $owner_type_id)
    {
        $con = Propel::getConnection();
        $sql = "
            SELECT * FROM EMT_EMAIL_LAYOUT
            WHERE OWNER_ID=$owner_id AND ".(is_null($owner_type_id) ? "OWNER_TYPE_ID IS NULL" : "OWNER_TYPE_ID=$owner_type_id")."
            ORDER BY ".myTools::NLSFunc(EmailLayoutPeer::NAME, 'SORT')."
        ";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return EmailLayoutPeer::populateObjects($stmt);
    }
}
