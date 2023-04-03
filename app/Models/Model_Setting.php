<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Setting extends Model {
	
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
	}
	//
	function setting($attr = null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_settings');
		if(!empty($attr)){
			$builder->where('attribute',$attr);
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
	//
	function general_search($text){
		//
		$builder = $this->db->table('bo_customer');
		$builder->like('username',$text);
		$builder->orLike('firstname',$text);
		$builder->orLike('lastname',$text);
		$builder->orLike('email',$text);
		$builder->orLike('nic',$text);
		return $builder;
	}
	

}