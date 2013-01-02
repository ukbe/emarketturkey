<?php

class aliveAction extends EmtAction
{
    public function execute($request)
    {
		session_destroy();
		return $this->renderText('OK');
    }

}
