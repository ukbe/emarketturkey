<?php

class TimePeriod extends BaseTimePeriod
{
    public function __toString()
    {
        return $this->getLabel();
    }

}
