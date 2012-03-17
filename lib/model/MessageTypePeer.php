<?php

class MessageTypePeer extends BaseMessageTypePeer
{
    CONST MTYP_PRODUCT_INQUIRY      = 1;
    CONST MTYP_PRODUCT_OFFERING     = 2;
    CONST MTYP_PARTNERSHIP          = 3;
    CONST MTYP_SERVICE_REQUEST      = 4;
    CONST MTYP_GENERAL_INQUIRY      = 5;
    CONST MTYP_REQ_FOR_QUOTATION    = 6;
    CONST MTYP_JOB_APPLICATION      = 7;
    CONST MTYP_JOB_APP_RESPONSE     = 8;
    CONST MTYP_GENERIC_MESSAGEE     = 9;
    CONST MTYP_ANNOUNCEMENT         = 10;
    
    public static function getOrderedNames($app_id = null, $filter_built_in = false, $for_select = false)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(myTools::NLSFunc(MessageTypeI18nPeer::NAME, 'SORT'));

        if ($filter_built_in) $c->add(MessageTypePeer::BUILT_IN, null, Criteria::ISNULL);
        
        if ($app_id) $c->add(MessageTypePeer::APPLICATION_ID, $app_id);

        if ($for_select)
        {
            $cats = self::doSelectWithI18n($c);
            $catys = array();
            foreach ($cats as $cat){
                $catys[$cat->getId()] = $cat->getName();
            }
            return $catys;
        }

        return self::doSelectWithI18n($c);
    }

}
