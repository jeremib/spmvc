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

class Dispatch {
	public $model;
	public $view;
	public $config;

	public function __construct() {
		$this->config = new Config;

		$this->attachView();
		$this->attachModel();

		$spmvc = new spMvc($this->model, $this->view, $this->config);
		$spmvc->dispatch(isset($_GET['route']) ? $_GET['route'] : 'pages/index');

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
}

$dispatch = new Dispatch();
