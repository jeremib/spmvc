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
	
	public function __construct($model, $view, $config) {
		$this->model = $model;
		$this->view = $view;
		$this->config = $config;
	}
	
	public function dispatch($route) {
		if ( preg_match('/^admin\//', $route) ) {
			$admin = true;
			$route = preg_replace('/^admin\//', '', $route); // strip it out
		} else {
			$admin = false;
		}

		if ( count(explode("/", $route)) == 1) {
			list($controller) = explode("/", $route);
		} else {
			list($controller, $action) = explode("/", $route);
		}
		
		$action = empty($action) ? 'index' : $action;
		
		if ( $admin ) {
			$action = "admin_{$action}";
		}
		
		$parameters = explode("/", $route);
		array_shift($parameters); // shift off the controller
		array_shift($parameters); // shift off the action
		
		$this->view->spmvc['controller'] = $controller;
		$this->view->spmvc['action'] = $action;
		$this->view->spmvc['parameters'] = $parameters;
		
		$class = new ReflectionClass(ucwords($controller) . "Controller");

		$controller_obj = $class->newInstanceArgs(array($this->model, $this->view));
		$method_obj = $class->getMethod($action);
		
		// assign the view engine to our controller
		$controller_obj->view =& $this->view;
		// assign the model engine to our controller
		$controller_obj->model =& $this->model;
		
		$method_obj->invokeArgs($controller_obj, $parameters);

		// give the view access to the session
		$this->view->assign('session', new Session);
		
		$controller_obj->preRender();
		
		// fetch the view, stick it in the layout
		// @todo add check for valid view
		//die(ROOT . DS . 'app/views/' . $controller . '/' . $action . '.phtml');
		$this->view->setPath('template', ROOT . DS . APP_DIR . DS . 'app' . DS .'views' . DS);
		$content_for_layout = $this->view->fetch($controller . DS . $action . '.phtml');
		$this->view->assign('content_for_layout', ( isset($content_for_layout) ? $content_for_layout : '') );
		$this->view->display('layouts' . DS . $controller_obj->layout . '.phtml');
	}
}
