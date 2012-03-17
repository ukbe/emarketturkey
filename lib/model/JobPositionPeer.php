<?php

class JobPositionPeer extends BaseJobPositionPeer
{
    public static function getOrderedNames($for_select = false)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(myTools::NLSFunc(JobPositionI18nPeer::NAME, 'SORT'));
        
        if ($for_select)
        {
            $cats = JobPositionPeer::doSelectWithI18n($c);
            $catys = array();
            foreach ($cats as $cat){
                $catys[$cat->getId()] = $cat->getName();
            }
            return $catys;
        }
        
        return JobPositionPeer::doSelectWithI18n($c);
    }

}
