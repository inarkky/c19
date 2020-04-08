<?php

namespace application\models;


use application\core\Model;
use application\helpers\Math;
use DOMDocument;
use DOMXPath;

class Statistics extends Model
{
    public static function analyze()
    {
        $numbers = [13, 18, 13, 14, 13, 16, 14, 21, 13];

        $stats = Math::describe($numbers, false); // Has optional parameter to set population or sample calculations
        echo "<pre>";
        print_r($stats);
    }

    public static function realtime()
    {
        $ch = curl_init(REALTIME_DATA_SOURCE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $page = curl_exec($ch);
print_r("1");
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($page);
        libxml_clear_errors();
        $xpath = new DOMXpath($dom);
print_r("2");
        $data = array();
        // get all table rows and rows which are not headers
        $rows = $xpath->query('//div[@class="right-part"]');
print_r("3");        
        foreach ($rows as $row) {
            //$cells = $row->getElementsByTagName('td');
            $cells = $xpath->query('td', $row);
            var_dump($cells);
            die();
            $cellData = [];
            foreach ($cells as $k => $cell) { 
                
                $cellData[$k] = $cell->nodeValue;
            }
            print_r("n");
            var_dump($cellData);
        }
print_r("4");
        die();
    }

}
