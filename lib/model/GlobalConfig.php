<?php

class GlobalConfig extends BaseGlobalConfig
{
    public function getCastedValue()
    {
        $val = $this->getValue();
        return settype($val, $this->getType());
    }
}
