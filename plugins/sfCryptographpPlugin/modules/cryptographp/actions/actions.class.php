<?php

class cryptographpActions extends sfActions
{
	public function executeIndex($request)
	{
		include_once (dirname(__FILE__).'/../../../lib/crypt/cryptographp.inc.php');
		return sfView::NONE;
	}
}

?>