<?php
require 'lib/savant/Savant3.php';
require 'lib/ezpdo/ezpdo_runtime.php';
require 'lib/spyc/spyc.php5';

error_reporting (E_ALL);
if (version_compare(phpversion(), '5.0.0', '<') == true) { die ('> PHP 5 Only'); }

// Constants:
define ('DIRSEP', DIRECTORY_SEPARATOR);

// Get site path
$site_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP;
define ('SITEPATH', $site_path);

// For loading classes
function __autoload($class_name) {
        $filename = $class_name . '.php';
			
		$look_in = array('app.controllers', 'app.models', 'app.services', 'app.views', 'core.includes');
		
		foreach($look_in as $path) {
	        $file = SITEPATH . str_replace('.', DIRSEP, $path) . DIRSEP . $filename;
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
