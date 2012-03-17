<?php

class JobFunction extends BaseJobFunction
{
    public function __toString()
    {
        return $this->getName();
    }
    
}
