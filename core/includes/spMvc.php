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
	public $view;
	public $model;
	public $config;
	
	public function __construct() {	
		$this->config = new Config;
		
		$this->attachView();
		$this->attachModel();

	}
	
	private function attachView() {
		$v = $this->config->get('app.libs');
		require_once "lib/views/{$v['view']}/_loader.php";

		$model = new ViewLoader($this);	
	}
	
	private function attachModel() {
		$v = $this->config->get('app.libs');
		require_once "lib/models/{$v['model']}/_loader.php";

		$model = new ModelLoader($this);		
	}
	
	public function dispatch($route) {
		if ( count(explode("/", $route)) == 1) {
			list($controller) = explode("/", $route);
		} else {
			list($controller, $action) = explode("/", $route);
		}
		
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
}
