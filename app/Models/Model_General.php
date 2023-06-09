<?php namespace App\Models;

use CodeIgniter\Model;

class Model_General extends Model {
	
	public function __construct(){

		parent::__construct();
		$this->db = \Config\Database::connect();
	}
	//
	function get_return_reason($id=null,$reason=null){
		$builder = $this->db->table('return_reason');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($reason)){
			$builder->where('reason',$reason);
		}
		$builder->orderBy('id');
		return $builder;
	}
	//
	function get_gateway($id = null,$serial=null,$assign_to=null,$status=null,$from=null,$to=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('gateway');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($serial)){
			$builder->where('serial',$serial);
		}if(!empty($assign_to)){
			$builder->where('assign_to',$assign_to);
		}if(!empty($status)){
			$builder->where('status',$status);
		}if(!empty($from)){
			$builder->where('assign_on >=',$from.' 00:00:00');
		}if(!empty($to)){
			$builder->where('assign_on <=',$to.' 23:59:59');
		}
		return $builder;
	}
	//
	function task_detail_insert($task_id=null, $status=null, $reject_reason=null, $picture1=null, $picture2=null, $picture3=null, $picture4=null, $picture5=null,$user_id=null){
		$db = \Config\Database::connect();
		//
		$data = array(
			'task_id' => $task_id,
			'status' => $status, 
			'reject_reason' => $reject_reason, 
			'picture1' => $picture1, 
			'picture2' => $picture2, 
			'picture3' => $picture3,
			'picture4' => $picture4,
			'picture5' => $picture5,
			'user_id' => $user_id
		);
		//
		$builder = $db->table('task_detail');
		$builder->insert($data);
	}
	//
	function get_misc_equipment($id = null,$name=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('miscellaneous_equipment');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($name)){
			$builder->where('name',$name);
		}
		return $builder;
	}
	//
	function get_task_misc_equipment($task_id = null,$equip_id=null, $task_detail_id=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('task_misc_equipment');
		if(!empty($task_id)){
			$builder->where('task_id',$task_id);
		}if(!empty($equip_id)){
			$builder->where('equip_id',$equip_id);
		}if(!empty($task_detail_id)){
			$builder->where('task_detail_id',$task_detail_id);
		}
		return $builder;
	}
	//
	function get_task_gateway($id = null,$task_id=null,$gw_serial=null, $task_detail_id=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('task_gateway');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($task_id)){
			$builder->where('task_id',$task_id);
		}if(!empty($gw_serial)){
			$builder->where('gateway_serial',$gw_serial);
		}if(!empty($task_detail_id)){
			$builder->where('task_detail_id',$task_detail_id);
		}
		return $builder;
	}
	//
	function get_devices_n_tools($id = null,$name=null){
		$builder = $this->db->table('devices_and_tools');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($name)){
			$builder->where('name',$name);
		}
		$builder->orderBy('id');
		return $builder;
	}
	//
	function get_users_devices_n_tools($user_id = null,$tool_id=null,$serial=null){
		$builder = $this->db->table('users_devices_and_tools');
		if(!empty($user_id)){
			$builder->where('user_id',$user_id);
		}if(!empty($tool_id)){
			$builder->where('tool_id',$tool_id);
		}if(!empty($serial)){
			$builder->where('serial',$serial);
		}
		$builder->orderBy('id');
		return $builder;
	}
	//
	function get_users_misc_equipment($equip_id=null,$user_id=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('users_misc_equipment');
		if(!empty($equip_id)){
			$builder->where('equip_id',$equip_id);
		}if(!empty($user_id)){
			$builder->where('user_id',$user_id);
		}
		return $builder;
	}
	//
	function get_gateway_taskStatusWise($user_id=null,$status=null,$date=null){
		$builder = $this->db->table('task_detail as detail');
		$builder->join('task_gateway as gateway','detail.id = gateway.task_detail_id');
		if(!empty($user_id)){
			$builder->where('detail.user_id',$user_id);
		}if(!empty($status)){
			$builder->where('detail.status',$status);
		}if(!empty($date)){
			$builder->where('detail.created_on >=',$date.' 00:00:00');
			$builder->where('detail.created_on <=',$date.' 23:59:59');
		}
		$builder->select('count(gateway.id) as gatewayCount');
		return $builder;
	}
	//
	function get_task_equip_count($from=null,$to=null,$user_id=null,$task_id=null,$equip_id=null,$status=null){
		$builder = $this->db->table('task_detail as task');
		$builder->join('task_misc_equipment as equi','task.id = equi.task_detail_id');
		if(!empty($status)){
			$builder->where('task.status',$status);
		} if(!empty($from)){
			$builder->where('equi.created_on >=',$from.' 00:00:00');
		} if(!empty($to)){
			$builder->where('equi.created_on <=',$to.' 23:59:59');
		} if(!empty($user_id)){
			$builder->where('task.user_id',$user_id);
		} if(!empty($equip_id)){
			$builder->where('equi.equip_id',$equip_id);
		} if(!empty($task_id)){
			$builder->where('task.task_id',$task_id);
		}
		return $builder;
	}
	//
	function get_devices_detail($device_id = null,$serial=null,$status=null,$user_id=null){
		$builder = $this->db->table('device_detail');
		if(!empty($device_id)){
			$builder->where('device_id',$device_id);
		}if(!empty($serial)){
			$builder->where('serial',$serial);
		}if(!empty($status)){
			$builder->where('status',$status);
		}if(!empty($user_id)){
			$builder->where('user_id',$user_id);
		}
		$builder->orderBy('id');
		return $builder;
	}
	//
	function get_sim($id = null,$icc_id=null,$user_id=null,$status=null,$from=null,$to=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('sim');
		if(!empty($id)){
			$builder->where('id',$id);
		}if(!empty($icc_id)){
			$builder->where('icc_id',$icc_id);
		}if(!empty($user_id)){
			$builder->where('user_id',$user_id);
		}if(!empty($status)){
			$builder->where('status',$status);
		}if(!empty($from)){
			$builder->where('assign_on >=',$from.' 00:00:00');
		}if(!empty($to)){
			$builder->where('assign_on <=',$to.' 23:59:59');
		}
		return $builder;
	}
	//
	function get_task_sim($id=null,$task_id = null,$icc_id=null, $task_detail_id=null){
		$db = \Config\Database::connect();
		//
		$builder = $db->table('task_sim as sim');
		$builder->join('task_detail as task','sim.task_detail_id = task.id');
		if(!empty($id)){
			$builder->where('sim.id',$id);
		}if(!empty($task_id)){
			$builder->where('task.task_id',$task_id);
		}if(!empty($icc_id)){
			$builder->where('sim.sim_icc_id',$icc_id);
		}if(!empty($task_detail_id)){
			$builder->where('task.id',$task_detail_id);
		}
		return $builder;
	}

}