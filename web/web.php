<?php

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
// -------------------------------------------------------------
if (!isset($_SERVER['SF_APP'])) {
   die('No application set');
}
define('SF_APP', $_SERVER['SF_APP']);

// -------------------------------------------------------------
if (!isset($_SERVER['SF_ENVIRONMENT'])) {
   die('No environment set');
}
define('SF_ENVIRONMENT', $_SERVER['SF_ENVIRONMENT']);

// -------------------------------------------------------------
if (isset($_SERVER['SF_DEBUG']))
{
    define('SF_DEBUG', (bool)$_SERVER['SF_DEBUG']);
}
else if (isset($_COOKIE['SF_DEBUG']))
{
    define('SF_DEBUG', (bool)$_COOKIE['SF_DEBUG']);
}
else
{
    define('SF_DEBUG', false);
}
// -------------------------------------------------------------
##IP_CHECK##
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration(SF_APP, SF_ENVIRONMENT, SF_DEBUG);
sfContext::createInstance($configuration)->dispatch();
