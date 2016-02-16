<?php
//defines
define("DOCUMENT_ROOT", realpath(dirname(__FILE__))."/public/");
define("PLUGINS",       realpath(DOCUMENT_ROOT."../plugins")."/");
define("INCLUDES",      realpath(DOCUMENT_ROOT."../includes")."/");
define("CONFIG",        realpath(DOCUMENT_ROOT."../config.php"));
define("MYSQL_DATA",    realpath(DOCUMENT_ROOT."../mysql_data.php"));

//error reporting
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

//autoload classes
function autoload_class($class) {
    require_once(INCLUDES."class.".$class.".php");
}
spl_autoload_register('autoload_class');