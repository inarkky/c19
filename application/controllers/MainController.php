<?php

namespace application\controllers;


use application\core\Controller;

class MainController extends Controller {

	public function indexAction() {
		$this->model->getStatusState();
		$this->model->getStatusCounty();
		$this->model->getStatusForm();

		$vars = [
			'errors' => [], //TODO: implement error handling
			'data' => $this->model
		];

		$this->view->render(null, $vars, 'default');
	}

}