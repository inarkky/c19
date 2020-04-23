<?php

namespace application\controllers;


use application\core\Controller;

class StatisticsController extends Controller
{

    public function indexAction()
    {
        $this->model->analyze();
    }
}
