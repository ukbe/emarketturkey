<?php

class JobFunctionPeer extends BaseJobFunctionPeer
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
        
        $c->addAscendingOrderByColumn(JobFunctionI18nPeer::NAME);
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
    
}
