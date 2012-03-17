<?php

class ProductAttrOption extends BaseProductAttrOption
{
    public function __toString()
    {
        return $this->getValue();
    }

}