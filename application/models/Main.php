<?php

namespace application\models;


use application\core\Model;

class Main extends Model 
{
    public $state;
    public $county;
    public $cumulative;
    public $form;

	public function getStatusState()
	{
        $this->state = [
            "tested"    => $this->parseObjectState("TESTIRANI"),
            "active"    => $this->parseObjectState("SLUCAJEVI"),
            "dead"      => $this->parseObjectState("UMRLI"),
            "recovered" => $this->parseObjectState("IZLIJECENI")
        ];

        return $this;
    }

    public function getStatusCounty()
    {
        $this->county = $this->parseObjectCounty();

        return $this;
    }

    public function getStatusForm()
    {
        $this->cumulative = $this->parseObjectForm("KUMULATIVNO"); 
        $this->form = $this->parseObjectForm("UKUPNO");

        return $this;
    }

    private function parseObjectState($status)
    {
        $params  = "&outStatistics="    . urlencode('[{"statisticType":"sum","onStatisticField":"'. $status .'","outStatisticFieldName":"value"}]');
        $params .= "&outFields="        . urlencode('*');

        $arr = json_decode($this->callAPI($params), true);
        
        return $arr['features'][0]['attributes']['value'];
    }

    private function parseObjectCounty()
    {
        $params  = "&orderByFields="    . urlencode('SLUCAJEVI desc,UMRLI asc');
        $params .= "&resultOffset="     . urlencode('0');
        $params .= "&resultRecordCount=". urlencode('5');
        $params .= "&outFields="        . urlencode('*');
        
        $arr = json_decode($this->callAPI($params), true);

        return $arr['features'];
    }

    private function parseObjectForm($type)
    {
        $params  = "&orderByFields="    . urlencode('DATUM asc');
        $params .= "&resultOffset="     . urlencode('0');
        $params .= "&resultRecordCount=". urlencode('2000');
        $params .= "&outFields="        . urlencode('OBJECTID,' . $type . ',DATUM,STATUS');

        $arr = json_decode($this->callAPI($params, true), true);

        return $arr['features'];
    }

    private function callAPI($custom, $chrono = false)
    {
        $method  = "GET";
        
        $params  = "f="                 . urlencode("json");
        $params .= "&where="            . urlencode('1=1');
        $params .= "&returnGeometry="   . urlencode('false');
        $params .= "&spatialRel="       . urlencode('esriSpatialRelIntersects');
        $params .= "&outSR="            . urlencode('102100');
        $params .= "&cacheHint="        . urlencode('true');
        $params .= $custom;

        ($chrono) ? $url = CHRONOLOGY_DATA_SOURCE : $url = REALTIME_DATA_SOURCE;
        $url .= $params;

        $curl = curl_init();
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        return $result;
    }
    
}