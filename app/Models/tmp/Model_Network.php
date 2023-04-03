<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Network extends Model {
	
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
	}
	//
	function get_olt($id=null,$name=null,$ip=null){
		$builder = $this->db->table('bo_olt');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($name)){
			$builder->where('name',$name);
		}if(!empty($ip)){
			$builder->where('ip',$ip);
		}
		$builder->orderBy('id');
		return $builder;
	}
	//
	public function get_pop(){
		$curl = \Config\Services::curlrequest();
		$response = $curl->get('https://nms.logon.com.pk/pop/api_get_pop');
		$body = $response->getBody();
		//
		return $data = (json_decode($body));
		//
		
	}
	

	

}