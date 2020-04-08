<?php

namespace application\controllers;


use application\core\Controller;
use application\helpers\Math;

class StatisticsController extends Controller
{

    public function indexAction()
    {
        //$this->model->analyze();
        $this->model->realtime();
    }
}
