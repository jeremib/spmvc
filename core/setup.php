<?php
error_reporting (E_ALL);
if (version_compare(phpversion(), '5.0.0', '<') == true) { die ('> PHP 5 Only'); }

// defines below borrowed from cakephp

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
	define('ROOT', dirname(dirname(dirname(__FILE__))));
}

if (!defined('APP_DIR')) {
	define('APP_DIR', basename(dirname(dirname(__FILE__))));
}

if (!defined('WEBROOT_DIR')) {
	define('WEBROOT_DIR', basename(dirname(__FILE__)));
}
if (!defined('WWW_ROOT')) {
	define('WWW_ROOT', dirname(__FILE__) . DS);
}


if (function_exists('ini_set') && ini_set('include_path', ROOT . PATH_SEPARATOR . ROOT . DS . APP_DIR . DS . PATH_SEPARATOR . ini_get('include_path'))) {
	define('APP_PATH', null);
	define('CORE_PATH', null);
} else {
	define('APP_PATH', ROOT . DS . APP_DIR . DS);
	define('CORE_PATH', ROOT . DS);
}

require APP_PATH . 'lib/spyc/spyc.php5';

// For loading classes
function __autoload($class_name) {
        $filename = $class_name . '.php';
			
		$look_in = array('app.controllers', 'app.models', 'app.services', 'app.views', 'core.includes');
		
		foreach($look_in as $path) {
	        $file = ROOT . DS . APP_DIR . DS . str_replace('.', DS, $path) . DS . $filename;
			if ( file_exists($file) ) {
				require $file;
				return true;
			}
		}
		
		// fall through means class not found

       	throw new Exception("Unable to autoload class {$class_name}.");
        return false;
}

function e($out) {
	echo '<pre class="output">';
	if ( is_array($out) || is_object($out) ) {
		echo print_r($out, 1);
	} else {
		echo $out;
	}
	echo '</pre>';
}
