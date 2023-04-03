<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Package extends Model {
	

	function get_package_internet($id=null,$name=null,$bandwidth=null,$city=null,$status=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_pkg_int');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($name)){
			$builder->where('name',$name);
		}if(!empty($bandwidth)){
			$builder->where('bandwidth',$bandwidth);
		}if(!empty($city)){
			$builder->where('city',$city);
		}if(!empty($status)){
			$builder->where('status',$status);
		}
		$builder->orderBy('id');
		return $builder;
	}
	// -----------------------------------------------------------------------------------------------------------
	function get_package_tv($id=null,$name=null,$city=null,$tvbox=null,$status=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_pkg_tv');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($name)){
			$builder->where('name',$name);
		}if(!empty($city)){
			$builder->where('city',$city);
		}if(!empty($status)){
			$builder->where('status',$status);
		}if(!empty($tvbox)){
			$builder->where('qty',$tvbox);
		}
		$builder->orderBy('id');
		return $builder;
	}
	// -----------------------------------------------------------------------------------------------------------
	function get_package_phone($id=null,$name=null,$city=null,$minutes=null,$status=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_pkg_phone');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($name)){
			$builder->where('name',$name);
		}if(!empty($city)){
			$builder->where('city',$city);
		}if(!empty($status)){
			$builder->where('status',$status);
		}if(!empty($minutes)){
			$builder->where('minutes',$minutes);
		}
		$builder->orderBy('id');
		return $builder;
	}



	function get_package($id=null,$name=null,$bandwidth=null,$city=null,$status=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_package');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($name)){
			$builder->where('name',$name);
		}if(!empty($bandwidth)){
			$builder->where('bandwidth',$bandwidth);
		}if(!empty($city)){
			$builder->where('city',$city);
		}if(!empty($status)){
			$builder->where('status',$status);
		}
		$builder->orderBy('id');
		return $builder;
	}
	
	
}