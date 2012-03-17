<?php

class SkillCategory extends BaseSkillCategory
{

    public function __toString()
    {
        return $this->getName(); 
    }
    
    public function getSubCategories()
    {
        $c = new Criteria();
        $c->add(SkillCategoryPeer::PARENT_ID, $this->id);
        $c->addAscendingOrderByColumn(SkillCategoryI18nPeer::NAME);
        return SkillCategoryPeer::doSelectWithI18n($c);
    }

}
