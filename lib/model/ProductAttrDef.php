<?php

class ProductAttrDef extends BaseProductAttrDef
{
    public function __toString()
    {
        return $this->getName(); 
    }

    public function getOptions($for_select = false)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(ProductAttrOptionPeer::SEQUENCE_NO);
        $options = $this->getProductAttrOptions($c);
        if ($for_select) {
            $opts = array();
            foreach ($options as $option){
                $opts[$option->getId()] = $option->getValue();
            }
        }
        return $for_select ? $opts : $options;
    }
}
