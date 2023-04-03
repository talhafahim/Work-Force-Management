<?php namespace App\Models;

use CodeIgniter\Model;

class Model_Task extends Model {
	/////////////////////////////////////////
	function get_task($id = null,$un=null,$assign_to=null,$status=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_customer_info');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($un)){
			$builder->where('un_number',$un);
		}if(!empty($assign_to)){
			$builder->where('assign_to',$assign_to);
		}if(!empty($status)){
			$builder->where('status',$status);
		}
		return $builder;
	}
	//
	function get_task_group($id = null,$un=null,$assign_to=null,$status=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('bo_customer_info');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($un)){
			$builder->where('un_number',$un);
		}if(!empty($assign_to)){
			$builder->where('assign_to',$assign_to);
		}if(!empty($status)){
			$builder->where('status',$status);
		}
		$builder->groupBy('un_number');
		return $builder;
	}
	//
	function get_task_detail($id = null,$task_id=null,$gateway=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('task_detail');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($task_id)){
			$builder->where('task_id',$task_id);
		}if(!empty($gateway)){
			$builder->where('gateway',$gateway);
		}
		return $builder;
	}

}