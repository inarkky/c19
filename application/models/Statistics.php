<?php

namespace application\models;


use application\core\Model;
use application\helpers\Math;

class Statistics extends Model
{
    public static function analyze()
    {
        $numbers = [13, 18, 13, 14, 13, 16, 14, 21, 13];

        $stats = Math::describe($numbers, false); // Has optional parameter to set population or sample calculations
        echo "<pre>";
        print_r($stats);
    }

}
