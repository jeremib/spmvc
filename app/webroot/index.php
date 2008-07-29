<?
/**
 * @author Jeremi Bergman <jeremi@innerserve.com>
 * @package spmvc
 * @subpackage core
 *
 * @copyright Copyright 2008 Jeremi Bergman Licensed under the Apache License,
 * Version 2.0 (the "License"); you may not use this file except in compliance with the
 * License.
 *
 * You may obtain a copy of the License at http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND,
 * either express or implied. See the License for the specific language governing permissions
 * and limitations under the License.
 */

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

// call our dispatcherer
require 'dispatch.php';
?>