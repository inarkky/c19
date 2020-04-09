<?php

namespace application\controllers;


use application\core\Controller;

class SocialController extends Controller
{
    public function twitterAction()
    {
        echo $this->model->callTwitterRequest();
    }

    public function redditAction()
    {
        $this->model->callRedditRequest();
    }
}
