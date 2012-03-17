<?php

class EventTypePeer extends BaseEventTypePeer
{
    CONST ECLS_TYP_BUSINESS       = 1;
    CONST ECLS_TYP_SOCIAL         = 2;
    CONST ECLS_TYP_ACADEMIC       = 3;
    
    public static $classTypeNames = array (1 => 'Business',
                                           2 => 'Social',
                                           3 => 'Academic',
                                        );
    
    public static function getOrderedNames($class = null)
    {
        $con = Propel::getConnection();
        
        $sql = "SELECT ID, NAME FROM EMT_EVENT_TYPE_I18N
                WHERE CULTURE='".sfContext::getInstance()->getUser()->getCulture()."' 
                    " . ($class ? "AND TYPE_CLASS=$class" : "") . "
                ORDER BY NAME
        ";
        
        $stmt = $con->prepare($sql);
        $stmt->execute();

        $list = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_NUM))
        {
            $list[$row[0]] = $row[1];
        }
        return $list;
    }
}
