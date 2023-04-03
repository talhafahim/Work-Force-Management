<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Tools extends Model {
	

	function get_cities(){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_city');
		$builder->orderBy('city');
		return $builder;
	}
	
	
}