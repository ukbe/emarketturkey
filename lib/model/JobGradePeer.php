<?php

class JobGradePeer extends BaseJobGradePeer
{
    public static function getSortedList($cr=null, $get_as_options = true)
    {
        if ($cr)
        {
            $c = clone $cr;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->addAscendingOrderByColumn(JobGradeI18nPeer::NAME);
        $list = self::doSelectWithI18n($c);
        
        if ($get_as_options)
        {
            $opts = array();
            foreach ($list as $item)
                $opts[$item->getId()] = $item->getName();
            return $opts;
        }
        else
            return $list;
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