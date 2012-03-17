<?php

class B2bLeadPeer extends BaseB2bLeadPeer
{
    CONST B2B_LEAD_SELLING                  = 1;
    CONST B2B_LEAD_BUYING                   = 2;
    
    public static $typeNames    = array (1 => 'Selling Lead',
                                         2 => 'Buying Lead'
                                         );
    
    public static function retrieveByGuid($guid)
    {
        $c = new Criteria();
        $c->add(B2bLeadPeer::GUID, $guid);
        return B2bLeadPeer::doSelectOne($c);
    }

    public static function getLeadFromUrl(sfParameterHolder $ph)
    {
        $c = new Criteria();
        $c->addJoin(B2bLeadPeer::COMPANY_ID, CompanyPeer::ID, Criteria::INNER_JOIN);
        $c->add(B2bLeadPeer::GUID, $ph->get('guid'));
        $c->add(B2bLeadPeer::ACTIVE, 1);
        $c->add(B2bLeadPeer::EXPIRES_AT, "TRUNC(EMT_B2B_LEAD.EXPIRES_AT) >= TRUNC(SYSDATE)", Criteria::CUSTOM);
        $c->add(CompanyPeer::AVAILABLE, 1);
        return self::doSelectOne($c);
    }

    public static function getFeaturedLeads($type_id = null, $maxnum = 20)
    {
        $l_type_id = myTools::pick_from_list($type_id, array_keys(B2bLeadPeer::$typeNames), null);
        $con = Propel::getConnection();
        
        $sql = "SELECT * FROM
                (
                    SELECT EMT_B2B_LEAD.*, rank() over (partition by company_id order by EMT_B2B_LEAD.CREATED_AT desc) rank
                    FROM EMT_B2B_LEAD
                    LEFT JOIN EMT_COMPANY ON EMT_B2B_LEAD.COMPANY_ID=EMT_COMPANY.ID
                    WHERE EMT_B2B_LEAD.ACTIVE=1 AND EMT_COMPANY.AVAILABLE=1
                    ".(isset($l_type_id) ? " AND EMT_B2B_LEAD.TYPE_ID=$l_type_id" : "")."
                    ORDER BY EMT_B2B_LEAD.CREATED_AT DESC
                )
                WHERE rank <= 3 and rownum <=$maxnum";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return B2bLeadPeer::populateObjects($stmt);
    }

    public static function getLatestLeads($type_id = null, $maxnum = 20)
    {
        $l_type_id = myTools::pick_from_list($type_id, array_keys(B2bLeadPeer::$typeNames), null);
        $con = Propel::getConnection();
        
        $sql = "SELECT * FROM
                (
                    SELECT EMT_B2B_LEAD.*, rank() over (partition by company_id order by EMT_B2B_LEAD.CREATED_AT desc) rank
                    FROM EMT_B2B_LEAD
                    LEFT JOIN EMT_COMPANY ON EMT_B2B_LEAD.COMPANY_ID=EMT_COMPANY.ID
                    WHERE EMT_B2B_LEAD.ACTIVE=1 AND EMT_COMPANY.AVAILABLE=1
                    AND TRUNC(EMT_B2B_LEAD.EXPIRES_AT) >= TRUNC(SYSDATE)
                    ".(isset($l_type_id) ? " AND EMT_B2B_LEAD.TYPE_ID=$l_type_id" : "")."
                    ORDER BY EMT_B2B_LEAD.CREATED_AT DESC
                )
                WHERE rank <= 3 and rownum <=$maxnum";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return B2bLeadPeer::populateObjects($stmt);
    }

}
