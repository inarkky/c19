<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller {

	public function indexAction() {
		$this->model->getStatusState();
		$this->model->getStatusCounty();
		$this->model->getStatusForm();
		
		var_dump($this->model);

		/*$vars = [
			'battle' => $result,
		];

		$this->view->render(null, $vars, 'default');*/
	}

}