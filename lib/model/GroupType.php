<?php

class GroupType extends BaseGroupType
{
    public function __toString()
    {
        return $this->getName(); 
    }
}
