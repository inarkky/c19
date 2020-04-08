<?php

namespace application\controllers;

use application\core\Controller;

class CommandsController extends Controller {

    public function listAction()
    {
        $this->model->listDataset();
    }

    public function getAction()
    {
        $this->model->getDataset();
    }

    public function setupAction() 
    {
        $this->model->setupDataset();
    }
    
    public function updateAction() 
    {
        $this->model->updateDataset();
    }

    public function parseAction()
    {
        $this->model->parseDataset();
    }

    public function editAction()
    {
        $this->model->editDataset();
    }

    public function purgeAction() 
    {
        $this->model->purgeDataset();
    }
}