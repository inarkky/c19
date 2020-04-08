<?php

namespace application\core;


use application\middleware\Logger;

class Middleware
{

    public static function debug()
    {
        Logger::run();
    }

}