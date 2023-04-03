<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Taxation extends Model {
	
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
	}
	//
	function get_taxation($id=null,$city=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_taxation');
		if(!empty($id)){
			$builder->where('serial',$id);
		}
		if(!empty($city)){
			$builder->where('city',$city);
		}
		return $builder;
	}

	function get_taxation2($city=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_taxation');
		if(!empty($city)){
			$builder->where('city',$city);
		}
		return $builder;
	}
	//
	function settingUpdate($attr,$value=null,$param=null){
		$data = array();
		$data['value'] = $value;
		$data['parameter'] = $param;
			//
		$this->db->table('bo_settings')->where('attribute',$attr)->update($data);
	}
	

}