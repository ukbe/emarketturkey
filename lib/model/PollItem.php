<?php

class PollItem extends BasePollItem
{
    public function getOwner()
    {
        return $this->getPoll();
    }
}
