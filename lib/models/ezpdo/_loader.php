<?php
/**
 * @author Jeremi Bergman <jeremi@innerserve.com>
 * @package spmvc
 * @subpackage spmvc.model.ezpdo
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
require "lib/models/ezpdo/ezpdo_runtime.php";
class ModelLoader {
	public function __construct(&$spmvc) {
		$spmvc->model = epManager::instance();
		$this->setEzpdoConfig($spmvc);
	}

	private function setEzpdoConfig($spmvc) {
		$which_db = $spmvc->config->get('app.database');

		$ezpdo_config['default_dsn'] = $spmvc->config->get('database.dsn.' . $which_db);
		$ezpdo_config['source_dirs'] = ROOT . DS . 'app' . DS . 'models';
		$ezpdo_config['compiled_dir'] = $ezpdo_config['source_dirs'] . DS . 'compiled';
		$ezpdo_config['recursive'] = 'true';
		$ezpdo_config['compiled_fil'] = '.compiled';
		$ezpdo_config['backup_compiled'] = 'false';
		$ezpdo_config['default_oid_column'] = 'id';
		$ezpdo_config['table_prefix'] = $spmvc->config->get('database.table.prefix');
		$ezpdo_config['auto_compile'] = 'true';
		$ezpdo_config['auto_flush'] = 'true';
		$ezpdo_config['db_lib'] = 'adodb';
		$spmvc->model->setConfig($ezpdo_config);
	}
}
?>