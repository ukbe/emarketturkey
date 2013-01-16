<?php

class badRequest400Action extends EmtAction
{
    public function execute($request)
    {
		return $this->renderText('HTTP 400 - Bad Request.<br /><br /><a href="http://www.emarketturkey.com">eMarketTurkey Home</a>', 400);
    }

}
