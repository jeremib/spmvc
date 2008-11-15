<?php
/**
 * @author Jeremi Bergman <jeremi@innerserve.com>
 * @package spmvc
 * @subpackage spmvc.model.doctrine
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
//require the base Doctrine class
require 'lib/models/doctrine/Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));

class ModelLoader {
	public function __construct(&$spmvc) {

		$spmvc->model = Doctrine_Manager::getInstance();
		$this->setEzpdoConfig($spmvc);
	}

	private function setEzpdoConfig($spmvc) {
		$which_db = $spmvc->config->get('app.database');
			
		$spmvc->model->setAttribute('model_loading', 'conservative');
		Doctrine::loadModels(ROOT . DS . APP_DIR . DS . 'app' . DS . 'models');
		
		$conn = $spmvc->model->openConnection($spmvc->config->get('database.dsn.' . $which_db));

		//$spmvc->config->get('database.table.prefix');
	}
}
?>