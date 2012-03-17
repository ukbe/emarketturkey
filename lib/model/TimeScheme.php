<?php

class TimeScheme extends BaseTimeScheme
{
    public function isOneDay()
    {
        return (date('d m Y', $this->getStartDate('U')) == date('d m Y', $this->getEndDate('U')));
    }
}
