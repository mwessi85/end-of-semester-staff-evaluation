<?php 
	defined("YEAR")? null : define("YEAR","2017"); 
	defined("RESOURCE_PATH")? null : define("RESOURCE_PATH","http://library.umu.ac.ug:82/public/");
	defined("SEMESTER")? null : define("SEMESTER","1");
	defined("STATUS")? null : define("STATUS","active");
	defined("DEPARTMENT_TYPE")? null : define("DEPARTMENT_TYPE","Academic");
	defined('DS') ? null : define("DS", DIRECTORY_SEPARATOR);
	//defined('SITE_ROOT') ? null : define("SITE_ROOT", dirname(__FILE__));
	defined('SITE_ROOT') ? null : define("SITE_ROOT", __DIR__);
	defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes'.DS);
	require_once(LIB_PATH."config.php");
	require_once(LIB_PATH."functions.php");
	require_once(LIB_PATH."session.php");
	require_once(LIB_PATH."database.php");
	require_once(LIB_PATH."user.php");
	require_once(LIB_PATH."staff.php");
	require_once(LIB_PATH."photograph.php");
	//require_once(LIB_PATH."comment.php");
	require_once(LIB_PATH."database_object.php");
	require_once(LIB_PATH."pagination.php");
	
?>