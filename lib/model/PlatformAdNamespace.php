<?php

class PlatformAdNamespace extends BasePlatformAdNamespace
{
    public function __toString()
    {
        return $this->getTitle();
    }

}
