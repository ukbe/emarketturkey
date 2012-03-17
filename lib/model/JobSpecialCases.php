<?php

class JobSpecialCases extends BaseJobSpecialCases
{
    public function __toString()
    {
        return $this->getName();
    }
}
