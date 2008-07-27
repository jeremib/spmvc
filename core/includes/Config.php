<?php
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
