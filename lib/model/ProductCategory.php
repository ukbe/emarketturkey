<?php

class ProductCategory extends BaseProductCategory
{
    public function __toString()
    {
        return $this->getName(); 
    }
    
    public function getSubCategories($for_select = false)
    {
        $c = new Criteria();
        $c->add(ProductCategoryPeer::PARENT_ID, $this->id);
        $c->addAscendingOrderByColumn(ProductCategoryI18nPeer::NAME);
        $cats = ProductCategoryPeer::doSelectWithI18n($c);
        
        if ($for_select){
            $catys = array();
            foreach ($cats as $cat){
                $catys[$cat->getId()] = $cat->getName();
            }
            return $catys;
        }
        
        return $cats; 
    }
    
    public function getParent()
    {
        return ProductCategoryPeer::retrieveByPK($this->getParentId());
    }
    
    public function getAttributes()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(ProductAttrDefPeer::SEQUENCE_NO);
        
        return $this->getProductAttrDefs($c);
    }

}