<?php
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

class Config {
	private $config;
	
	public function __construct() {
		$this->loadConfig();
	}
	
	public function get($path) {
		$pieces = explode(".", $path);
		
		$path = '$this->config';
		foreach($pieces as $piece) {
			$path .= "['{$piece}']";
		}
		$path .= ";";
		
		return eval("return {$path}");
	}
	
	private function loadConfig() {
		$yamls = glob("app/config/*.yml");
		foreach($yamls as $file) {
			list($type) = explode('.', basename($file));
			
			$this->config[$type] = Spyc::YAMLLoad($file);
		}
	}
}
?>
