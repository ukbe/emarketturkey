<?php

class BlockReason extends BaseBlockReason
{
    public function __toString()
    {
        return $this->getName(); 
    }
    
}
