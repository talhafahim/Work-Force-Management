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
	//
	function get_total_equip_cost($date){
		$builder = $this->db->table('bo_customer_info as task')
		->join('task_misc_equipment as equi','task.id = equi.task_id')
		->where('task.status','commission')
		->where('equi.created_on >=',$date.' 00:00:00')
		->where('equi.created_on <=',$date.' 23:59:59')
		->select('sum(total) as total_sum');
		return $builder;
	}
	//
	function get_total_team_cost($date){
		$builder = $this->db->table('bo_customer_info as task')
		->join('task_team_member as team','task.id = team.task_id')
		->join('bo_users as user','user.id = team.user_id')
		->where('task.status','commission')
		->where('team.status','commission')
		->where('team.created_on >=',$date.' 00:00:00')
		->where('team.created_on <=',$date.' 23:59:59')
		->select('sum(staff_cost) as total_sum');
		return $builder;
	}
	//
	function get_total_gateway_revenue($date){
		$builder = $this->db->table('bo_customer_info as task')
		->join('task_gateway as gate','task.id = gate.task_id')
		->join('gateway as gateway','gateway.serial = gate.gateway_serial')
		->where('task.status','commission')
		->where('gate.created_on >=',$date.' 00:00:00')
		->where('gate.created_on <=',$date.' 23:59:59')
		->select('sum(cost) as total_sum');
		return $builder;
	}
	//
	function get_total_commission($date){
		$builder = $this->db->table('bo_customer_info as task')
		->join('task_detail as detail','task.id = detail.task_id')
		->where('task.status','commission')
		->where('detail.status','commission')
		->where('detail.created_on >=',$date.' 00:00:00')
		->where('detail.created_on <=',$date.' 23:59:59')
		->select('task.id');
		return $builder;
	}

}