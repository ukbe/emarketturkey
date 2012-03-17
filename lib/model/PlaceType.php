<?php

class PlaceType extends BasePlaceType
{
    public function __toString()
    {
        return $this->getName();
    }
}
