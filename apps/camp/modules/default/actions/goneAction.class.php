<?php

class goneAction extends EmtAction
{
    public function execute($request)
    {
		return $this->renderText('HTTP 410 - Content has been permanently removed.');
    }

}
