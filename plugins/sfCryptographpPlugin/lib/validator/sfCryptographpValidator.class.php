<?php

$cryptinstall = dirname(__FILE__).'/../crypt/cryptographp.fct.php';
//include_once(dirname(__FILE__).'/../crypt/cryptographp.fct.php');
include_once($cryptinstall);

class sfCryptographpValidator extends sfValidator
{
	public function execute(&$value, &$error)
	{
		if (chk_crypt($value)) {
			return true;
		} else {
			$error = $this->getParameter('code_error');
			return false;
		}
	}
	
	public function initialize($context, $parameters = null)
	{
		// initialize parent
		parent::initialize($context);
		
		$this->getParameterHolder()->set('code_error', 'wrong code');
		
		$this->getParameterHolder()->add($parameters);
		
		return true;
	}
}

?>