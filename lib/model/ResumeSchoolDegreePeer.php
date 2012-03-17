<?php

class ResumeSchoolDegreePeer extends BaseResumeSchoolDegreePeer
{
    CONST RSC_DEG_SORT_NAME         = 1;
    CONST RSC_DEG_SORT_LEVEL_SEQ    = 2;
    
    public static function getSortedList($cr=null, $get_as_options = true, $sort_type = null)
    {
        $arr = array(self::RSC_DEG_SORT_NAME        => ResumeSchoolDegreeI18nPeer::NAME,
                     self::RSC_DEG_SORT_LEVEL_SEQ   => ResumeSchoolDegreePeer::LEVEL_SEQ,
                );
        
        if ($cr)
        {
            $c = clone $cr;
        }
        else
        {
            $c = new Criteria();
        }
        
        if ($sort_type)
            $c->addAscendingOrderByColumn($arr[$sort_type]);
        else
            $c->addAscendingOrderByColumn(ResumeSchoolDegreeI18nPeer::NAME);

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
