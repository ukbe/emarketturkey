<?php

class ProductQuantityUnit extends BaseProductQuantityUnit
{
    public function __toString()
    {
        return $this->getName();
    }
}