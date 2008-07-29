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

class spmvc {
	private $view;
	private $model;
	private $config;
	
	public function __construct($view, $model) {
		$this->view = $view;
		$this->model = $model;
		
		$this->config = new Config;
		
		// set ezpdo config
		$this->setEzpdoConfig();

	}
	
	public function dispatch($route) {
		// surpress any errors/warnings
		list($controller, $action) = @explode("/", $route);
		
		$action = empty($action) ? 'index' : $action;
		
		$parameters = explode("/", $route);
		array_shift($parameters); // shift off the controller
		array_shift($parameters); // shift off the action
		
		$class = new ReflectionClass(ucwords($controller) . "Controller");

		$controller_obj = $class->newInstanceArgs(array($this->view, $this->model));
		$method_obj = $class->getMethod($action);
		
		// assign the view engine to our controller
		$controller_obj->view =& $this->template;
		// assign the model engine to our controller
		$controller_obj->model =& $this->model;
		
		$method_obj->invokeArgs($controller_obj, $parameters);
		
		// fetch the view, stick it in the layout
		// @todo add check for valid view
		//die(ROOT . DS . 'app/views/' . $controller . '/' . $action . '.phtml');
		$this->view->setPath('template', ROOT . DS . 'app' . DS .'views' . DS);
		$content_for_layout = $this->view->fetch($controller . DS . $action . '.phtml');
		$this->view->assign('content_for_layout', ( isset($content_for_layout) ? $content_for_layout : '') );
		$this->view->display('layouts' . DS . 'default.phtml');
	}
	
	private function setEzpdoConfig() {
		$which_db = $this->config->get('app.database');
		
		$ezpdo_config['default_dsn'] = $this->config->get('database.dsn.' . $which_db);
		$ezpdo_config['source_dirs'] = ROOT . DS . 'app' . DS . 'models';
		$ezpdo_config['compiled_dir'] = $ezpdo_config['source_dirs'] . DS . 'compiled';
		$ezpdo_config['recursive'] = 'true';
		$ezpdo_config['compiled_file'] = '.compiled';
		$ezpdo_config['backup_compiled'] = 'false';
		$ezpdo_config['default_oid_column'] = 'id';
		$ezpdo_config['table_prefix'] = $this->config->get('database.table.prefix');
		$ezpdo_config['auto_compile'] = 'true';
		$ezpdo_config['auto_flush'] = 'true';
		$ezpdo_config['db_lib'] = 'adodb';
		$this->model->setConfig($ezpdo_config);
	}
}
