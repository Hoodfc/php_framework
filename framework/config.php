<?php 
define('ROOT', $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR);
define('CONTROLLER_PATH', ROOT . 'src' . DIRECTORY_SEPARATOR .'controller' . DIRECTORY_SEPARATOR);
define('VIEW_PATH', ROOT . 'src' . DIRECTORY_SEPARATOR .'view' . DIRECTORY_SEPARATOR);
define('FRAMEWORK_PATH', ROOT . 'framework' . DIRECTORY_SEPARATOR);
define('CORE_PATH', FRAMEWORK_PATH . 'core' . DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', ROOT . 'www' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
define('CACHE_PATH', ROOT . 'cache' . DIRECTORY_SEPARATOR );

//print's function for debuf purpose
function lazy_print($value, $what = null)
{
	print $what . ': ';
	if (is_array($value) || is_object($value)) 
		print_r($value);	
	else
		print $value;
	print "<BR>";
}

?>
