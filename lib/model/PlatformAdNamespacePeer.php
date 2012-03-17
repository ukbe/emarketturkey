<?php

class PlatformAdNamespacePeer extends BasePlatformAdNamespacePeer
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
        
        $c->addAscendingOrderByColumn(self::AD_NAMESPACE);
        $list = self::doSelect($c);
        
        if ($get_as_options)
        {
            $opts = array();
            foreach ($list as $item)
                $opts[$item->getId()] = $item;
            return $opts;
        }
        else
            return $list;
    }
}
