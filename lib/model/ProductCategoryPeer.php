<?php

class ProductCategoryPeer extends BaseProductCategoryPeer
{
    public static function getBaseCategories($cr=null, $for_select = false)
    {
        if ($cr)
        {
            $c = clone $cr;
        }
        else
        {
            $c = new Criteria();
        }
        
        $c->add(ProductCategoryPeer::PARENT_ID, 0);
        $c->addAscendingOrderByColumn(myTools::NLSFunc(ProductCategoryI18nPeer::NAME, 'SORT'));
        
        $cats  = ProductCategoryPeer::doSelectWithI18n($c);
        
        if ($for_select)
        {
            $catys = array();
            foreach ($cats as $cat){
                $catys[$cat->getId()] = $cat->getName();
            }
            return $catys;
        }
        
        return $cats; 
    }
    
    public static function getSubCategoriesOf($id)
    {
        $cat = self::retrieveByPK($id);
        return ($cat)?$cat->getSubCategories():array();
    }

    public static function retrieveByStrippedCategory($category)
    {
        $c = new Criteria();
        $c->add(ProductCategoryI18nPeer::STRIPPED_CATEGORY, $category);
        $cats = self::doSelectWithI18n($c);
        if (is_array($cats) && count($cats))
        {
            return $cats[0];
        }
        else
        {
            return null;
        }
    }
}