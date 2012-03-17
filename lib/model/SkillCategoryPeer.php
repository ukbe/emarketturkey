<?php

class SkillCategoryPeer extends BaseSkillCategoryPeer
{
    public static function getBaseCategories($cr=null)
    {
        if ($cr)
        {
            $c = clone $cr;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(SkillCategoryPeer::PARENT_ID, null, Criteria::ISNULL);
        $c->addAscendingOrderByColumn(SkillCategoryI18nPeer::NAME);
        return SkillCategoryPeer::doSelectWithI18n($c);
    }
}
