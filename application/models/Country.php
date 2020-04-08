<?php

namespace application\models;


use application\core\Model;

class Country extends Model
{
	protected static $_table = 'countries';
	protected static $_primaryKey = 'id';

	public $id;
	public $neighbour;
	public $region;
    public $country;
    
	public function getCountry($key, $value)
	{
        return $this->getAll([$key => $value]);
    }

    public function getAllCountries()
	{
        return $this->getAll();
    }

    public function createCountry($key, $value)
	{

    }

    public function updateCountry($key, $value)
	{

    }

    public function deleteCountry($key, $value)
	{

    }
    


}
