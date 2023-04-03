<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Project extends Model {
	
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
	}
	//
	function get_city($id=null,$city=null){
		$builder = $this->db->table('bo_city');
		if(!empty($id)){
			$builder->where('serial',$id);
		}if(!empty($city)){
			$builder->where('city',$city);
		}
		$builder->orderBy('city');
		return $builder;
	}
	//
	function get_area($area=null,$city=null){
		$builder = $this->db->table('bo_area');
		if(!empty($area)){
			$builder->where('area',$area);
		}if(!empty($city)){
			$builder->where('city',$city);
		}
		$builder->orderBy('city');
		return $builder;
	}
	//
	function get_project($id=null,$city=null,$area=null,$project=null){
		$builder = $this->db->table('bo_project');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($area)){
			$builder->where('area',$area);
		}if(!empty($city)){
			$builder->where('city',$city);
		}if(!empty($project)){
			$builder->where('project',$project);
		}
		$builder->orderBy('city');
		return $builder;
	}

	

}