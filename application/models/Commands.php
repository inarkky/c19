<?php

namespace application\models;


use application\core\Model;
use datetime;
use dateinterval;
use dateperiod;
use exception;

class Commands extends Model
{
	protected static $_table = 'status';
	protected static $_primaryKey = 'id';

	public $id;
	public $country_id;
	public $date;
	public $active;
	public $death;
	public $recovered;

	public function listDataset()
	{
		return $this->getAll([], null, null, null, 'date');
	}

	public function getDataset()
	{
		$id = $this->request->get("id");
		$x = $this->findOne($id);
		var_dump($x);
	}

	public function setupDataset()
	{
		$this->world = new Country();

		foreach ($this->defineInterval() as $dt) {
			if($this->fetchDataset($dt->format("m-d-Y"))) 
				break;
		}

		echo "<br<hr>>DONE<hr>";
		die;
	}

	public function updateDataset()
	{
		$this->world = new Country();

		$lastRecord = $this->max_attribute_in_array($this->listDataset(), "date");
		$startInterval = (new DateTime($lastRecord))->add(new DateInterval("P1D"))->format('Y-m-d');

		foreach ($this->defineInterval($startInterval) as $dt) {
			if ($this->fetchDataset($dt->format("m-d-Y"))) 
				break;
		}

		echo "<br<hr>>DONE<hr>";
		die;
	}

	public function parseDataset()
	{
		$this->world = new Country();
		$date = new DateTime($this->request->get("date"));

		$this->fetchDataset($date->format("m-d-Y"));

		echo json_encode($date->format("m-d-Y") . " - DONE");
		exit;
	}

	public function editDataset()
	{

	}

	public function purgeDataset()
	{
		$this->purge();
	}

	private function createRecord($dataset)
	{
		$this->set("country_id", $dataset['country_id']);
		$this->set("date", $dataset['date']);
		$this->set("active", $dataset['active']);
		$this->set("death", $dataset['death']);
		$this->set("recovered", $dataset['recovered']);

		try {
			if(!$this->create()) 
				throw new Exception("CreateRecord::Error Processing Request", 1);
		}catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	private function fetchDataset($date)
	{
		$csv = SOURCE . $date . FORMAT;

		if($this->get_http_response_code($csv) != "200"){
			return true; //No more data, exit loop
		}else{
			$data = file_get_contents($csv);
		}
		
		$rows = explode("\n",$data);

		foreach($rows as $row) {
			if(!empty($row))
			$countries = $this->world->getCountry("Country", str_getcsv($row)[3]);
			if(!empty($countries) && str_getcsv($row)[2] == ""){
				$country_id = $countries[0];
				$dataset = [
					"country_id" => $country_id->id,
					"date" => date("Y-m-d", strtotime(str_getcsv($row)[4])),
					"death" => str_getcsv($row)[8],
					"recovered" => str_getcsv($row)[9],
					"active" => str_getcsv($row)[10]
				];
				
				$this->createRecord($dataset);
			}
		}

		echo "<hr>FINISHED DATE " . $date . "<br>";
	}

	private function defineInterval($startDate = "2020-01-22") //1st time recorded
	{
		$begin = new DateTime($startDate); 
		$end = new DateTime(); //Today

		$interval = DateInterval::createFromDateString('1 day');
		
		return new DatePeriod($begin, $interval, $end);
	}

	private function get_http_response_code($url) 
	{
		$headers = get_headers($url);
		return substr($headers[0], 9, 3);
	}

	private function max_attribute_in_array($array, $prop)
	{
		return max(array_column($array, $prop));
	}

}
