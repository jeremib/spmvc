<?
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
		$content_for_layout = $this->view->fetch('app/views/' . $controller . '/' . $action . '.phtml');
		$this->view->assign('content_for_layout', ( isset($content_for_layout) ? $content_for_layout : '') );
		$this->view->display('app/views/layouts/default.phtml');
	}
	
	private function setEzpdoConfig() {
		$which_db = $this->config->get('app.database');
		
		$ezpdo_config['default_dsn'] = $this->config->get('database.dsn.' . $which_db);
		$ezpdo_config['source_dirs'] = 'app/models';
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
