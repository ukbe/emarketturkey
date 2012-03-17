<?php

function cryptographp_picture()
{
	$ret = "<img id=\"cryptogram\" src=\"".url_for('cryptographp/index')."\" alt=\"Cryptographp Picture\">";
	return $ret;
}

function cryptographp_reload()
{
	$reload_img = sfConfig::get('app_cryptographp_reloadimg', '/sfCryptographpPlugin/images/reload');
	//$ret = "<a style=\"cursor:pointer\" onclick=\"javascript:document.getElementById('cryptogram').src='".url_for('cryptographp/index?id=')."/'+Math.round(Math.random(0)*1000)+1\">".image_tag('/sfCryptographpPlugin/images/reload')."</a>";
	$ret = "<a style=\"cursor:pointer\" onclick=\"javascript:document.getElementById('cryptogram').src='".url_for('cryptographp/index?id=')."/'+Math.round(Math.random(0)*1000)+1\">".image_tag($reload_img)."</a>";
	return $ret;
}

?>