<?

class Controller {
	private $view;
	private $model;
	
	public function __construct($model, $view) {
		$this->view = $view;
		$this->model = $model;
	}
	
	public function index() {

	}
}