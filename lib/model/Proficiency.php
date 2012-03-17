<?php

class Proficiency extends BaseProficiency
{
    public function __toString()
    {
        return $this->getName(); 
    }

}
