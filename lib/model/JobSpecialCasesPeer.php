<?php

class JobSpecialCasesPeer extends BaseJobSpecialCasesPeer
{
    CONST JSCTYP_HANDICAPPED        = 1;
    CONST JSCTYP_TERROR_VICTIM      = 2;
    CONST JSCTYP_VETERAN            = 3;
    CONST JSCTYP_FORMER_CONVICT     = 4;
    
    public static function getSpecialCases($type_id = 0)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(JobSpecialCasesI18nPeer::NAME);
        return self::doSelectWithI18n($c);
    }
    
    public static function validateIdList($list)
    {
        $list = !is_array($list) ? array($list) : $list;
        $c = new Criteria();
        $c->clearSelectColumns();
        $c->addSelectColumn(self::ID);
        $c->add(self::ID, $list, Criteria::IN);
        $valid_st = BasePeer::doSelect($c);
        return $valid_st->fetchAll(PDO::FETCH_COLUMN, 0);
    }
}