<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Field extends Model {
	
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
	}
	//
	function get_ndt($id=null,$proj_id=null,$color=null,$splitter=null){
		$builder = $this->db->table('bo_ndt');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($proj_id)){
			$builder->where('project_id',$proj_id);
		}if(!empty($color)){
			$builder->where('core_color',$color);
		}if(!empty($splitter)){
			$builder->where('splitter',$splitter);
		}
		$builder->orderBy('id');
		return $builder;
	}
	//
	function get_adt($id=null,$customer=null){
		$builder = $this->db->table('bo_adt');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($customer)){
			$builder->where('customer',$customer);
		}
		$builder->orderBy('id');
		return $builder;
	}

}